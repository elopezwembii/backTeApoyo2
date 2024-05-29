<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Persona;
use App\Models\Suscripcion;
use App\Models\User;

use App\Services\MercadoPagoService;
use MercadoPago\SDK;
use MercadoPago;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        private MercadoPagoService $mercadoPagoService
    ) {}

    public function registrar(Request $request)
    {
        try {
            $user = User::create([
                'rut' => $request->rut,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'estado' => 1,
                'intentos' => 3,
                'primera_guia' => 1,
                'id_empresa' => $request->empresa == -1 ? null : $request->empresa,
            ]);
            $user->roles()->attach(1);

            $pe = Persona::find($request->persons_id);
            $pe->nombre = $request->nombres;
            $pe->apellido = $request->apellidos;
            $pe->status = 1;
            $pe->save();

            $request->merge(["email" => $user->email]);
            //enviar correo

            return $this->usarCupon($request);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un problema al registrar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function process(Request $request)
    {
        
        $payment = $this->mercadoPagoService->crearPreferencia($request);
        //registrar datos en bd
        
        /*
        $return = User::where('email', $request->email)->exists();
        if(!$return){
            return response()->json([
                'code' => 400,
                'message' => "Bat Request"
            ]);  
        }*/

        //suscriptores
        $persona = Persona::where('email', $request->email)->first();
        if (!$persona) {
            $persona = new Persona;
            $persona->nombre = $request->nombres;
            $persona->apellido = $request->apellidos;
            $persona->email = $request->email;
            $persona->tipo_usuario = $request->tipo_usuario;
            $persona->empresa = $request->empresa;
            $persona->save();
        }

        //planes
        /*
        $plan = Plan::where('uid', $request->uid)->first();
        if (!$plan) {
            return response()->json(['error' => 'Plan no es válido'], 400);
        }*/

        $suscripcion = Suscripcion::where('personas_id', $persona->id)->first();
        if (!$suscripcion) {
            $suscripcion = new Suscripcion;
            $suscripcion->personas_id = $persona->id;
            $suscripcion->planes_id = $request->planes_id;
            $suscripcion->save();
        }

        $payment->persons_id = $persona->id;

        return response()->json($payment);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        
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
       
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
    }
}
