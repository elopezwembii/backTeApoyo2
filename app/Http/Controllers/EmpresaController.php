<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function getEmpresas()
    {
        return response()->json(Empresa::with('getEncargado')->get(), 200);
    }

    public function crearEmpresaYEncargado(Request $request)
    {


        $request->validate([
            'rut' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'nombreEmpresa' => 'required',
            'password' => 'required',
            'cantidad_colaboradores' => 'required|numeric'
        ]);

        $admin = User::create([
            'rut' => $request->rut,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'estado' => 1,
            'intentos' => 3,
            'primera_guia' => 0,
            'rut' => $request->rut, // Agregado: RUT
            'nombres' => $request->nombres, // Agregado: Nombres
            'apellidos' => $request->apellidos, // Agregado: Apellidos
        ]);
        $admin->roles()->attach(4);

        $empresa = Empresa::create([
            'nombre' => $request->nombreEmpresa,
            'cantidad_colaboradores' => $request->cantidad_colaboradores,
            'estado' => 1,
            'id_admin' => $admin->id,
        ]);

        // Actualizar el campo id_empresa del usuario
        $admin->id_empresa = $empresa->id;
        $admin->save();

        return response()->json([
            'message' => 'Empresa Creada'
        ], 200);
    }

    public function getCantidadColaboradores(int $id, Request $request)
    {
        if (!is_null($id)) {
            $empresa = Empresa::find($id);

            if ($empresa) {
                $cantidadColaboradores = $empresa->getCantidadColaboradores();

                $cupoDisponible = false;
                if ($cantidadColaboradores < $empresa->cantidad_colaboradores) {
                    $cupoDisponible = true;
                }

                return response()->json([
                    'limiteColaboradores' => $empresa->cantidad_colaboradores,
                    'cantidadColaboradores' => $cantidadColaboradores,
                    'cupoDisponible' => $cupoDisponible
                ], 200);
            } else {
                // La empresa con el ID proporcionado no fue encontrada
                return response()->json(['message' => 'Empresa no encontrada'], 404);
            }
        } else {
            // El ID proporcionado es nulo
            return response()->json(['message' => 'ID de empresa nulo'], 400);
        }
    }
}
