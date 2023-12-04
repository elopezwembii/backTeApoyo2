<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Persona;
use App\Models\Suscripcion;

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

    public function process(Request $request)
    {
        
        $payment = $this->mercadoPagoService->crearPreferencia($request);
        //registrar datos en bd
        //suscriptores
        $persona = Persona::where('email', $request->email)->first();
        if (!$persona) {
            $persona = new Persona;
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
