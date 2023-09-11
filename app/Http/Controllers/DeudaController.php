<?php

namespace App\Http\Controllers;

use App\Models\Deuda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeudaController extends Controller
{
    public function registrarDeuda(Request $request)
    {
        $request->validate([
            'deuda_pendiente' => 'required|numeric',
            'cuotas_totales' => 'required|numeric',
            'cuotas_pagadas' => 'required|numeric',
            'pago_mensual' => 'required|numeric',
            'dia_pago' => 'required|numeric',
            'id_banco' => 'required|numeric',
            'id_tipo_deuda' => 'required|numeric'
        ]);
        $user = Auth::user();

        $deuda = Deuda::create([
            'desc' => $request->desc ? $request->desc : 'Deuda',
            'saldada' => 0,
            'deuda_pendiente' => $request->deuda_pendiente,
            'cuotas_totales' => $request->cuotas_totales,
            'cuotas_pagadas' => $request->cuotas_pagadas,
            'pago_mensual' => $request->pago_mensual,
            'dia_pago' => $request->dia_pago,
            'id_usuario' => $user->id,
            'id_banco' => $request->id_banco,
            'id_tipo_deuda' => $request->id_tipo_deuda
        ]);
        return response()->json(
            $deuda,
            200
        );
    }

    public function obtenerDeudas()
    {
        $user = Auth::user();
        $deudas = Deuda::where([['id_usuario', $user->id], ['saldada', 0]])->get();
        return response()->json(
            $deudas,
            200
        );
    }

    public function eliminarDeuda(int $id)
    {
        $deuda = Deuda::where('id', $id)->first();
        // Eliminar los gastos asociados a la deuda
        $deuda->gastos()->delete();
        // Eliminar la deuda
        $deuda->delete();
        return response()->json([
            'message' => 'Deuda borrada'
        ], 200);
    }

    public function editarDeuda(int $id, Request $request)
    {
        $deuda = Deuda::where('id', $id)->first();
        if ($deuda) {
            $deuda->deuda_pendiente = $request->deuda_pendiente;
            $deuda->cuotas_totales = $request->cuotas_totales;
            $deuda->cuotas_pagadas = $request->cuotas_pagadas;
            $deuda->pago_mensual = $request->pago_mensual;
            $deuda->saldada = $deuda->cuotas_totales == $deuda->cuotas_pagadas ? 1 : 0;
            $deuda->save();
            return response()->json([
                'message' => 'Deuda editada'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No encontrado'
            ], 404);
        }
    }
}
