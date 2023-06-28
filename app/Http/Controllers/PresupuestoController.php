<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Item_presupuesto;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresupuestoController extends Controller
{
    public function createOrReturnPresupuesto(Request $request)
    {
        $request->validate([
            'mes' => 'required|numeric',
            'anio' => 'required|numeric',
        ]);

        $presupuesto = Presupuesto::where([['mes', $request->mes], ['anio', $request->anio], ['id_usuario', Auth::user()->id]])->with('getItems')->get();
        //calculo total de ingresos
        $ingresos = Ingreso::where([['id_usuario', Auth::user()->id], ['fijar', true]])->get(); //agregar f.termino mayor a mes y año
        $suma = 0;

        foreach ($ingresos as $ingreso) {
            if ($ingreso->mes_termino == null) {
                if ($ingreso->anio < $request->anio) {
                    $suma += $ingreso->monto_real;
                } elseif ($ingreso->anio == $request->anio) {
                    if ($ingreso->mes <= $request->mes) {
                        $suma += $ingreso->monto_real;
                    }
                }
            } else {
                if ($ingreso->anio < $request->anio) {
                    if ($ingreso->anio_termino >= $request->anio) {
                        $suma += $ingreso->monto_real;
                    }
                } elseif ($ingreso->anio == $request->anio) {
                    if ($ingreso->mes <= $request->mes) {
                        if ($ingreso->mes_termino >= $request->mes) {
                            $suma += $ingreso->monto_real;
                        }
                    }
                }
            }
        }

        $ingresos = Ingreso::where([['id_usuario', Auth::user()->id], ['fijar', false], ['mes', $request->mes], ['anio', $request->anio]])->get();
        foreach ($ingresos as $ingreso) {
            $suma += $ingreso->monto_real;
        }


        if (count($presupuesto) > 0) {
            return response()->json(
                ['presupuesto' => $presupuesto, 'ingreso' => $suma],
                200
            );
        } else {
            $presupuestoNuevo = Presupuesto::create([
                'mes' => $request->mes,
                'anio' => $request->anio,
                'id_usuario' => Auth::user()->id,
                'fijado' => 0
            ]);
            $presupuesto = Presupuesto::where('id', $presupuestoNuevo->id)->with('getItems')->get();
            return response()->json(
                ['presupuesto' => $presupuesto, 'ingreso' => $suma],
                200
            );
        }
    }

    public function agregarItem(Request $request)
    {
        $request->validate([
            'tipo_gasto' => 'required|numeric',
            'monto' => 'required|numeric',
            'id_presupuesto' => 'required|numeric',
        ]);

        $presupuesto = Presupuesto::where('id', $request->id_presupuesto)->first();
        if (count($presupuesto->getItems) > 0) {
            $aux = false;
            foreach ($presupuesto->getItems as $item) {
                if ($item->tipo_gasto == $request->tipo_gasto) {
                    $item->monto = $request->monto;
                    $item->save();
                    $aux = false;
                    break;
                } else {
                    $aux = true;
                }
            }
            if ($aux) {
                Item_presupuesto::create([
                    'monto' => $request->monto,
                    'id_presupuesto' => $request->id_presupuesto,
                    'tipo_gasto' => $request->tipo_gasto
                ]);
            }
        } else {
            Item_presupuesto::create([
                'monto' => $request->monto,
                'id_presupuesto' => $request->id_presupuesto,
                'tipo_gasto' => $request->tipo_gasto
            ]);
        }
        return response()->json([
            'message' => "Presupuesto añadido",
        ], 200);
    }

    public function replicaPresupuesto(Request $request)
    {
        $request->validate([
            'mes_actual' => 'required|numeric',
            'anio_actual' => 'required|numeric',
            'mes_anterior' => 'required|numeric',
            'anio_anterior' => 'required|numeric',
        ]);
        $presupuestoActual = Presupuesto::where([['mes', $request->mes_actual], ['anio', $request->anio_actual], ['id_usuario', Auth::user()->id]])->first();
        $presupuestoAnterior = Presupuesto::where([['mes', $request->mes_anterior], ['anio', $request->anio_anterior], ['id_usuario', Auth::user()->id]])->first();

        if ($presupuestoActual->fijado == 1) {
            return response()->json([
                'message' => false,
            ], 404);
        }
        if (count($presupuestoAnterior->getItems) > 0) {
            foreach ($presupuestoAnterior->getItems as $item) {
                Item_presupuesto::create([
                    'monto' => $item->monto,
                    'tipo_gasto' => $item->tipo_gasto,
                    'id_presupuesto' => $presupuestoActual->id
                ]);
            }
            $presupuestoActual->fijado = 1;
            $presupuestoActual->save();

            return response()->json([
                'message' => 'Presupuesto clonado del mes anterior',
            ], 200);
        } else {
            return response()->json([
                'message' => false,
            ], 404);
        }
    }

    public function eliminarItem(int $id)
    {
        $item = Item_presupuesto::where('id', $id)->first();
        $item->delete();
        return response()->json([
            'message' => 'Item eliminado',
        ], 200);
    }
}
