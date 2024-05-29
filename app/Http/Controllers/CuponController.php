<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Empresa;
use App\Models\Cupon;
use App\Models\Plan;
use App\Models\Persona;
use App\Models\Suscripcion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmail;

use App\Http\Controllers\PagosController;
use App\Services\MercadoPagoService;
use MercadoPago\SDK;
use MercadoPago;

class CuponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cupones = Cupon::all();
        return response()->json($cupones);
    }

    public function enviarCorreo(Request $request)
    {
        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => $request->password
        ];

        try {
            Mail::to(env("MAIL_FROM_NAME"))->send(new UserEmail($data));
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }

    public function registrar(Request $request)
    {
        try {

            $prev = DB::table("previos")->where("email", $request->email)->first();
            if($prev !== null){

                $request->request->add([
                    'tipo_usuario' => 'individual', 
                    'empresa' => 'S/E'
                ]);
                
                //sin cupon
                if($prev->codigo_cupon == "---" && $prev->frequency == 0){
                    
                    $users = User::where('email', $request->email)->first();
                    if($users == null){
                        $user = User::create([
                            'rut' => $request->rut,
                            'nombres' => $request->nombres,
                            'apellidos' => $request->apellidos,
                            'email' => $request->email,
                            'password' => bcrypt($request->password),
                            'estado' => 1,
                            'intentos' => 3,
                            'primera_guia' => 1,
                            'id_empresa' => null,
                        ]);
                        $user->roles()->attach(1);
                    }
                    
                    $pe = Persona::find($prev->person_id);
                    $pe->nombre = $request->nombres;
                    $pe->apellido = $request->apellidos;
                    $pe->status = 1;
                    $pe->save();
        
                    $request->merge(["email" => $request->email]);
                    //enviar correo
                    $this->enviarCorreo($request);

                    $mercadoPagoService = new MercadoPagoService();
                    $pagosController = new PagosController($mercadoPagoService);
                    $pross = $pagosController->process($request);
                    
                    //borra linea
                    DB::table('previos')->where('id', $prev->id)->delete();

                    return $pross;

                }else{

                    $users = User::where('email', $request->email)->first();
                    if($users == null){
                        $user = User::create([
                            'rut' => $request->rut,
                            'nombres' => $request->nombres,
                            'apellidos' => $request->apellidos,
                            'email' => $request->email,
                            'password' => bcrypt($request->password),
                            'estado' => 1,
                            'intentos' => 3,
                            'primera_guia' => 1,
                            //'id_empresa' => $request->empresa == -1 ? null : $request->empresa,
                            'id_empresa' => null,
                        ]);
                        $user->roles()->attach(1);
                    }

                    $pe = Persona::find($prev->person_id);
                    $pe->nombre = $request->nombres;
                    $pe->apellido = $request->apellidos;
                    $pe->status = 1;
                    $pe->save();
        
                    $request->merge(["email" => $request->email]);
                    //enviar correo
                    $this->enviarCorreo($request);
                    $usarCupon = $this->usarCupon($request);
                    
                    //borra linea
                    DB::table('previos')->where('id', $prev->id)->delete();

                    return response()->json([
                        'code' => 200
                    ], 200);
                }
            
            }else{
                return response()->json([
                    'code' => 401,
                    'message' => 'El email no corresponde al registrado, por favor ingrese el email correcto'
                ], 401);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un problema al registrar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function usarCupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo_cupon' => ['required','string'],
        ]);
        
        /*
        $return = User::where('email', $request->email)->exists();
        if(!$return){
            return response()->json([
                'code' => 400,
                'message' => "Bat Request"
            ]);  
        }*/
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        
        //con empresa
        $cupon = Plan::where('cupon', $request->codigo_cupon)
                ->where('frequency', $request->frequency)//agregada validacion
                ->with('empresa')->first();
        if (!$cupon) {
            return response()->json(['error' => 'Cupón no es válido, o no corresponde al periodo seleccionado (mensual ó anual)'], 400);
        }

        //limita los cupos en funcion a la cantidad de colaboradores en la tabla empresas
        $empresa = Empresa::find($cupon->empresa_id);
        if($empresa != null){
            $cantidad_suscripciones = Suscripcion::where('cupones_id', $cupon->id)->count();
            if ($cantidad_suscripciones >= $empresa->cantidad_colaboradores) {
                return response()->json(['error' => 'Los cupos disponibles han llegado a su limite para esta empresa'], 400);
            }
        }

        if ($cupon->status !== 'active') {
            return response()->json(['error' => 'El cupón está inactivo, o no corresponde al periodo seleccionado (mensual ó anual)'], 400);
        }

        //suscriptores
        $persona = Persona::where('email', $request->email)->first();
        if (!$persona) {
            $persona = new Persona;
            $persona->nombre = $request->nombres;
            $persona->apellido = $request->apellidos;
            $persona->email = $request->email;
            $persona->tipo_usuario = $cupon->tipo;
            $persona->empresa = ($cupon->empresa != null)?$cupon->empresa->nombre:"S/E";
            $persona->save();
            //enviar correo para completar datos
        }

        $suscripcion = Suscripcion::where('personas_id', $persona->id)->where('planes_id', $cupon->id)->first();
        if (!$suscripcion) {
            $suscripcion = new Suscripcion;
            $suscripcion->personas_id = $persona->id;
            $suscripcion->planes_id = $cupon->id;
            $suscripcion->save();
        }

        $cantidad = Suscripcion::where('planes_id', $cupon->id)->count();

        return response()->json([
            'planSuscripcion' => $cupon,
            'email' => $request->email,
            'tipo_usuario' => $cupon->tipo,
            'empresa' => ($cupon->empresa != null)?$cupon->empresa->nombre:"S/E",
            'person_id' => $persona->id
        ], 200);

        /*
        return response()->json([
            'mensaje' => 'Por favor, realizar pago en MercadoPago', 
            'precioSuscripcion' => '',
            'precioCupon' => '',
            'persona' => $persona->email,
            'tipoSuscripcion' => $cupon->frequency_type,
            'cantidadSuscriptores' => $cantidad
        ], 200);
        */
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required',
            'descuento' => 'required',
            'tipo' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $length = 8;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $codigo = '';
        for ($i = 0; $i < $length; $i++) {
            $codigo .= $characters[rand(0, $charactersLength - 1)];
        }

        $cupon = new Cupon;
        $cupon->codigo = $request->codigo ? $request->codigo : $codigo;
        $cupon->descripcion = $request->descripcion;
        $cupon->descuento = $request->descuento;
        $cupon->tipo = $request->tipo;
        $cupon->fecha_inicio = $request->fecha_inicio;
        $cupon->fecha_fin = $request->fecha_fin;
        $cupon->save();

        return response()->json(['success' => 'Cupón creado exitosamente.', 'cupon' => $cupon], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Cupon $cupon)
    {
        return response()->json(['cupon' => $cupon], 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'string|max:255',
            'descripcion' => 'string|max:255',
            'descuento' => 'numeric|min:0',
            'tipo' => 'in:individual,colectivo',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date|after_or_equal:fecha_inicio',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $tag = Cupon::findOrFail($request->id);

        if ($tag) {
            $tag->update([
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'descuento' => $request->descuento,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'tipo' => $request->tipo
            ]);

            return response()->json(
                $tag,
                200
            );
            
        } else {
            return response()->json(
                ['error'=>"No se encontró el cupón"],
                404
            );
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cupon = Cupon::findOrFail($id);
        $cupon->delete();
        return response()->json(['success' => true]);
    }
}
