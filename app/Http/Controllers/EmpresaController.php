<?php

namespace App\Http\Controllers;

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
            'email' => 'required|email',
            'password' => 'required',
            'nombre' => 'required',
            'cantidad_colaboradores' => 'required|numeric',
        ]);

        $admin = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'estado' => 1,
            'intentos' => 3,
            'primera_guia' => 0,
        ]);
        $admin->roles()->attach(4);

        $empresa = Empresa::create([
            'nombre' => $request->nombre,
            'cantidad_colaboradores' => $request->cantidad_colaboradores,
            'estado' => 1,
            'id_admin' => $admin->id,
        ]);

        return response()->json([
            'message' => 'Empresa Creada'
        ], 200);
    }
}
