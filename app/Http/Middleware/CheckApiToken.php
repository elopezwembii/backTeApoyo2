<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Persona;

class CheckApiToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('api_token');

        if (!$token) {
            return response()->json(['error' => 'No ha proporcionado un token válido'], 401);
        }

        $user = Persona::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        return $next($request);
    }
}
