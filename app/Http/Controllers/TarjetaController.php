<?php

namespace App\Http\Controllers;

use App\Models\Tarjeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TarjetaController extends Controller
{
    public function registrarTarjeta(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
            'utilizado' => 'required|numeric',
            'id_banco' => 'required|numeric',
            'tipo' => 'required',

        ]);
        $user = Auth::user();

        $deuda = Tarjeta::create([
            'total' => $request->total,
            'utilizado' => $request->utilizado,
            'tipo' => $request->tipo,
            'id_usuario' => $user->id,
            'id_banco' => $request->id_banco,

        ]);
        return response()->json(
            $deuda,
            200
        );
    }

    public function obtenerTarjetas()
    {
        $user = Auth::user();
        $deudas = Tarjeta::where('id_usuario', $user->id)->get();
        return response()->json(
            $deudas,
            200
        );
    }

    public function eliminarTarjeta(int $id)
    {
        $deuda = Tarjeta::where('id', $id)->first();
        $deuda->delete();
        return response()->json([
            'message' => 'Tarjeta borrada'
        ], 200);
    }

    public function editarTarjeta(int $id, Request $request)
    {
        $deuda = Tarjeta::where('id',$id)->first();
        if ($deuda) {
            $deuda->total = $request->total;
            $deuda->utilizado = $request->utilizado;
            $deuda->tipo = $request->tipo;
            $deuda->id_banco = $request->id_banco;
            $deuda->save();
            return response()->json([
                'message' => 'Tarjeta editada'
            ], 200);
        }else {
            return response()->json([
                'message' => 'No encontrado'
            ], 404);
        }

    }
}
