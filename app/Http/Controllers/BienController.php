<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BienController extends Controller
{
    public function registrarBien(Request $request)
    {
        $request->validate([
            'desc' => 'required',
            'valorado' => 'required|numeric',
            'tipo_valorizacion' => 'required|numeric',
            'tipo_bien' => 'required|numeric'

        ]);
        $user = Auth::user();

        $bien = Bien::create([
            'desc' => $request->desc,
            'valorado' => $request->valorado,
            'tipo_valorizacion' => $request->tipo_valorizacion,
            'id_usuario' => $user->id,
            'tipo_bien' => $request->tipo_bien

        ]);
        return response()->json(
            $bien,
            200
        );
    }

    public function obtenerBienes()
    {
        $user = Auth::user();
        $bienes = Bien::where('id_usuario', $user->id)->get();
        return response()->json(
            $bienes,
            200
        );
    }

    public function eliminarBien(int $id)
    {
        $bien = Bien::where('id', $id)->first();
        $bien->delete();
        return response()->json([
            'message' => 'Tarjeta borrada'
        ], 200);
    }

    public function editarBien(int $id, Request $request)
    {
        $bien = Bien::where('id', $id)->first();
        if ($bien) {
            $bien->desc = $request->desc;
            $bien->valorado = $request->valorado;
            $bien->tipo_valorizacion = $request->tipo_valorizacion;
            $bien->tipo_bien = $request->tipo_bien;
            $bien->save();
            return response()->json([
                'message' => 'Bien editada'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No encontrado'
            ], 404);
        }
    }
}
