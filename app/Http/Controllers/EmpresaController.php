<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmpresaController extends Controller
{
    public function getEmpresas()
    {
        return response()->json(Empresa::with('getEncargado')->get(), 200);
    }

    public function crearEmpresaYEncargado(Request $request)
    {

       // Log::info($request);
        $request->validate([
            'rut' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'nombreEmpresa' => 'required',
            'cantidad_colaboradores' => 'required|numeric',
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
}
