<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Registro de usuario
     */
    public function signUp(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string',
            'email' => 'required|string|email|unique:usuarios',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'rut' => $request->rut,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'estado' => 1,
            'intentos' => 3,
            'primera_guia' => 1,
        ]);

        $user->roles()->attach(1);

        return response()->json([
            'message' => 'Usuario creado'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'No autorizado'
            ], 401);

            $user = User::where('email', $request->email)->with('empresa')->first();

        $tokenResult = $user->createToken("te-apoyo");

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        


        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'user' => $user,
            'rol' => $user->roles()->first(),
            'nivel'=>$user->calcularNivel()
        ]);
    }
}
