<?php

namespace App\Http\Controllers;

use App\Models\Ahorro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AhorroController extends Controller
{
    public function registrarAhorro(Request $request)
    {
        $request->validate([
            'meta' => 'required|numeric',
            'recaudado' => 'required|numeric',
            'fecha_limite' => 'required|date',
            'tipo_ahorro' => 'required|numeric',
        ]);
        $user = Auth::user();

        $ahorro = Ahorro::create([
            'desc' => $request->desc ? $request->desc : 'Ahorro',
            'meta' => $request->meta,
            'recaudado' => $request->recaudado,
            'fecha_limite' => $request->fecha_limite,
            'tipo_ahorro' => $request->tipo_ahorro,
            'id_usuario' => $user->id,
        ]);
        return response()->json(
            $ahorro,
            200
        );
    }

    public function obtenerAhorros()
    {
        $user = Auth::user();
        $ahorro = Ahorro::where([['id_usuario', $user->id]])->get();
        return response()->json(
            $ahorro,
            200
        );
    }

    public function eliminarAhorro(int $id)
    {
        $ahorro = Ahorro::findOrFail($id);
    
        // Eliminar los gastos asociados al ahorro
        $ahorro->gastos()->delete();
    
        // Eliminar el ahorro
        $ahorro->delete();
    
        return response()->json([
            'message' => 'ahorro y gastos asociados borrados'
        ], 200);
    }
    

    public function editarAhorro(int $id, Request $request)
    {
        $request->validate([
            'meta' => 'numeric',
            'recaudado' => 'numeric',
            'fecha_limite' => 'date',
            'tipo_ahorro' => 'numeric',
        ]);
        $ahorro = Ahorro::where('id', $id)->first();
        if ($ahorro) {
            $ahorro->meta = $request->meta;
            $ahorro->recaudado = $request->recaudado;
            $ahorro->fecha_limite = $request->fecha_limite;
            $ahorro->tipo_ahorro = $request->tipo_ahorro;
            $ahorro->save();
            return response()->json([
                'message' => 'Ahorro editada'
            ], 200);
        } else {
            return response()->json([
                'message' => 'No encontrado'
            ], 404);
        }
    }

    public function actualizarMonto(int $id, Request $request)
    {
        $request->validate([
            'recaudado' => 'required|numeric',
        ]);
    
        $ahorro = Ahorro::where('id', $id)->first();
    
        if ($ahorro) {
            // Sumar el valor actual de 'recaudado' con el valor enviado en la solicitud
            $ahorro->recaudado += $request->recaudado;
            $ahorro->save();
    
            return response()->json([
                'message' => 'Monto del ahorro actualizado'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Ahorro no encontrado'
            ], 404);
        }
    }
    

}
