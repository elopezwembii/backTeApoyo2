<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getPerfil(int $id)
    {
        $user = User::where('id', $id)->first();
        return response()->json(
            $user,
            200
        );
    }

    public function agregarUsuario(Request $request)
    {   
        //Log::info($request);

        $request->validate([
            'email' => 'string|email',
        ]);
        $user = User::create([
            'rut' => $request->rut,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'estado' => 1,
            'intentos' => 3,
            'primera_guia' => 1,
            'id_empresa' => $request->empresa,
        ]);

        $user->roles()->attach(1);
        return response()->json([
            'message' => 'usuario creado'
        ], 200);
    }

    public function editarPerfil(int $id, Request $request)
    {
        $request->validate([
            'fecha_nacimiento' => 'date|nullable',
            'rut' => 'string|nullable',
            'nombres' => 'string|nullable',
            'apellidos' => 'string|nullable',
            'genero' => 'string|nullable',
            'nacionalidad' => 'string|nullable',
            'ciudad' => 'string|nullable',
            'direccion' => 'string|nullable',
            'telefono' => 'string|nullable',
            'email' => 'string|nullable',
        ]);
        $user = User::where('id', $id)->first();
        $user->rut = $request->rut;
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->genero = $request->genero;
        $user->nacionalidad = $request->nacionalidad;
        $user->ciudad = $request->ciudad;
        $user->direccion = $request->direccion;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->save();


        return response()->json([
            'message' => 'usuario editado'
        ], 200);
    }

    public function obtenerUsuarios()
    {
        return response()->json(User::with('roles')->get(), 200);
    }

    public function cambiarEstado(int $id)
    {
        $user = User::where('id', $id)->first();
        $user->estado == 1 ? $user->estado = 0 : $user->estado = 1;
        $user->save();

        return response()->json([
            'message' => 'usuario editado'
        ], 200);
    }
}
