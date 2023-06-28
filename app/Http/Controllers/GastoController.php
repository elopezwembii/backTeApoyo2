<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GastoController extends Controller
{
    public function registerGasto(Request $request)
    {

        $request->validate([
            'monto' => 'required|numeric',
            'fijar' => 'required|boolean',
            'tipo_gasto' => 'required|numeric',
            'subtipo_gasto' => 'required|numeric'
        ]);
        $user = Auth::user();

        $gasto = Gasto::create([
            'desc' => $request->desc ? $request->desc : 'Gasto',
            'monto' => $request->monto,
            'dia' => $request->dia,
            'mes' => $request->mes,
            'anio' => $request->anio,
            'fijar' => $request->fijar,
            'id_usuario' => $user->id,
            'tipo_gasto' => $request->tipo_gasto,
            'subtipo_gasto' => $request->subtipo_gasto,
        ]);
        return response()->json(
            $gasto,
            200
        );
    }

    public function editGasto(int $id, Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'fijar' => 'required|boolean',
            'tipo_gasto' => 'required|numeric',
        ]);
        $gasto = Gasto::where('id', $id)->first();

        //verificar 4 condiciones
        //1.- viene fijar desde front e gasto tiene fijar (gasto->fechatermino y crear nuevo gasto con fijado de datos).
        if ($gasto->fijar) {
            //si el año de gasto es igual al año de editado
            if ($gasto->anio == $request->anioSelect) {
                //si el mes del gasto es menor al del editado
                if ($gasto->mes < $request->mesSelect) {
                    //actualiza la fecha de termino del gasto
                    $gasto->mes_termino = $request->mesSelect - 1;
                    $gasto->anio_termino = $request->anioSelect;
                    $gasto->save();

                    $gasto = gasto::create([
                        'desc' => $request->desc ? $request->desc : 'gasto',
                        'monto' => $request->monto,
                        'dia' => $request->dia,
                        'mes' => $request->mesSelect,
                        'anio' => $request->anioSelect,
                        'fijar' => $request->fijar,
                        'id_usuario' => $gasto->id_usuario,
                        'tipo_gasto' => $request->tipo_gasto,
                        'subtipo_gasto' => $request->subtipo_gasto,
                    ]);
                    return response()->json([
                        'message' => "Gasto editado!",
                    ], 200);
                    //si el mes de gasto es igual al de editado
                } else {
                    $gasto->desc = $request->desc ? $request->desc : 'gasto';
                    $gasto->monto = $request->monto;
                    $gasto->dia = $request->dia ? $request->dia : $gasto->dia;
                    $gasto->fijar = $request->fijar;
                    $gasto->tipo_gasto = $request->tipo_gasto;
                    $gasto->subtipo_gasto = $request->subtipo_gasto;
                    $gasto->save();
                    return response()->json([
                        'message' => "Gasto editado!",
                    ], 200);
                }
            }
        }


        $gasto->desc = $request->desc ? $request->desc : 'gasto';
        $gasto->monto = $request->monto;
        $gasto->dia = $request->dia ? $request->dia : $gasto->dia;
        $gasto->fijar = $request->fijar;
        $gasto->tipo_gasto = $request->tipo_gasto;
        $gasto->subtipo_gasto = $request->subtipo_gasto;
        $gasto->save();

        return response()->json([
            'message' => 'Gasto editado'
        ], 200);
    }

    public function deleteGasto(int $id)
    {
        $gasto = Gasto::where('id', $id)->first();
        $gasto->delete();

        return response()->json([
            'message' => 'Gasto borrado'
        ], 200);
    }


    public function getGastoFijo(Request $request)
    {
        $respuesta = [];
        $gastos = Gasto::where([['id_usuario', Auth::user()->id], ['fijar', true]])->with("getSubTipo")->get();
        foreach ($gastos as $gasto) {
            if ($gasto->mes_termino == null) {
                if ($gasto->anio < $request->anio) {
                    array_push($respuesta, $gasto);
                } elseif ($gasto->anio == $request->anio) {
                    if ($gasto->mes <= $request->mes) {
                        array_push($respuesta, $gasto);
                    }
                }
            } else {
                if ($gasto->anio < $request->anio) {
                    if ($gasto->anio_termino >= $request->anio) {
                        array_push($respuesta, $gasto);
                    }
                } elseif ($gasto->anio == $request->anio) {
                    if ($gasto->mes <= $request->mes) {
                        if ($gasto->mes_termino >= $request->mes) {
                            array_push($respuesta, $gasto);
                        }
                    }
                }
            }
        }
        return response()->json(
            $respuesta,
            200
        );
    }

    public function getGastoVariable(Request $request)
    {
        $ingresos = Gasto::where([['id_usuario', Auth::user()->id], ['mes', $request->mes], ['anio', $request->anio], ['fijar', false]])->with("getSubTipo")->get();
        return response()->json(
            $ingresos,
            200
        );
    }

    /* public function getTotalFijoMes(Request $request)
    {
        $ingresos = Ingreso::where([['id_usuario', Auth::user()->id], ['fijar', true]])->get();
        $suma = 0;

        foreach ($ingresos as $ingreso) {
            if ($ingreso->anio < $request->anio) {
                $suma += $ingreso->monto_real;
            } elseif ($ingreso->anio == $request->anio) {
                if ($ingreso->mes <= $request->mes) {
                    $suma += $ingreso->monto_real;
                }
            }
        }
        return response()->json(
            $suma,
            200
        );
    }

    public function getTotalVariableMes(Request $request)
    {
        $ingresos = Ingreso::where([['id_usuario', Auth::user()->id], ['fijar', false], ['mes', $request->mes], ['anio', $request->anio]])->get();
        $suma = 0;
        foreach ($ingresos as $ingreso) {
            $suma += $ingreso->monto_real;
        }
        return response()->json(
            $suma,
            200
        );
    } */
}
