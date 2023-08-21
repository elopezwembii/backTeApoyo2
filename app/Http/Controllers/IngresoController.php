<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class IngresoController extends Controller
{
    public function registerIngreso(Request $request)
    {

        $request->validate([
            'montoReal' => 'required|numeric',
            'fijar' => 'required|boolean',
            'tipo' => 'required|numeric'
        ]);
        $user = Auth::user();
        $ingreso = Ingreso::create([
            'desc' => $request->desc ? $request->desc : 'Ingreso',
            'monto_real' => $request->montoReal,
            'dia' => $request->dia,
            'mes' => $request->mes,
            'anio' => $request->anio,
            'fijar' => $request->fijar,
            'id_usuario' => $user->id,
            'tipo_ingreso' => $request->tipo,
        ]);
        return response()->json(
            $ingreso,
            200
        );
    }

    public function editIngreso(int $id, Request $request)
    {
        $request->validate([
            'montoReal' => 'required|numeric',
            'fijar' => 'required|boolean',
            'tipo' => 'required|numeric'
        ]);
        $ingreso = Ingreso::where('id', $id)->first(); //validar y responder en caso de que no exista.

        //verificar 4 condiciones
        //1.- viene fijar desde front e ingreso tiene fijar (ingreso->fechatermino y crear nuevo ingreso con fijado de datos).
        if ($ingreso->fijar) {
            //si el año de ingreso es igual al año de editado
            if ($ingreso->anio == $request->anioSelect) {
                //si el mes del ingreso es menor al del editado
                if ($ingreso->mes < $request->mesSelect) {
                    //actualiza la fecha de termino del ingreso
                    $ingreso->mes_termino = $request->mesSelect - 1;
                    $ingreso->anio_termino = $request->anioSelect;
                    $ingreso->save();

                    $ingreso = Ingreso::create([
                        'desc' => $request->desc ? $request->desc : 'Ingreso',
                        'monto_real' => $request->montoReal,
                        'dia' => $request->dia,
                        'mes' => $request->mesSelect,
                        'anio' => $request->anioSelect,
                        'fijar' => $request->fijar,
                        'id_usuario' => $ingreso->id_usuario,
                        'tipo_ingreso' => $request->tipo,
                    ]);
                    return response()->json([
                        'message' => "Ingreso editado!",
                    ], 200);
                    //si el mes de ingreso es igual al de editado
                } else {
                    $ingreso->desc = $request->desc ? $request->desc : 'Ingreso';
                    $ingreso->monto_real = $request->montoReal;
                    $ingreso->dia = $request->dia ? $request->dia : $ingreso->dia;
                    $ingreso->fijar = $request->fijar;
                    $ingreso->tipo_ingreso = $request->tipo;
                    $ingreso->save();
                    return response()->json([
                        'message' => "ingreso editado!",
                    ], 200);
                }
            }
        }

        $ingreso->desc = $request->desc ? $request->desc : 'Ingreso';
        $ingreso->monto_real = $request->montoReal;
        $ingreso->dia = $request->dia ? $request->dia : $ingreso->dia;
        $ingreso->fijar = $request->fijar;
        $ingreso->tipo_ingreso = $request->tipo;
        $ingreso->save();

        return response()->json([
            'message' => 'Ingreso editado'
        ], 200);
    }

    public function deleteIngreso(int $id)
    {
        $ingreso = Ingreso::where('id', $id)->first(); //validar
        $ingreso->delete();

        return response()->json([
            'message' => 'Ingreso borrado'
        ], 200);
    }

    public function getAllIngresos(Request $request)
    {
        $id = Auth::user();
        if ($id) {
            return response()->json(
                $id->getIngresos,
                200
            );
        } else {
            return response()->json([
                'message' => 'No encontrado'
            ], 401);
        }
    }

    public function getIngresoFijo(Request $request)
    {
        $respuesta = [];
        $ingresos = Ingreso::where([['id_usuario', Auth::user()->id], ['fijar', true]])->get(); //agregar f.termino mayor a mes y año
        foreach ($ingresos as $ingreso) {
            if ($ingreso->mes_termino == null) {
                if ($ingreso->anio < $request->anio) {
                    array_push($respuesta, $ingreso);
                } elseif ($ingreso->anio == $request->anio) {
                    if ($ingreso->mes <= $request->mes) {
                        array_push($respuesta, $ingreso);
                    }
                }
            } else {
                if ($ingreso->anio < $request->anio) {
                    if ($ingreso->anio_termino >= $request->anio) {
                        array_push($respuesta, $ingreso);
                    }
                } elseif ($ingreso->anio == $request->anio) {
                    if ($ingreso->mes <= $request->mes) {
                        if ($ingreso->mes_termino >= $request->mes) {
                            array_push($respuesta, $ingreso);
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

    public function getIngresoVariable(Request $request)
    {
        $ingresos = Ingreso::where([['id_usuario', Auth::user()->id], ['mes', $request->mes], ['anio', $request->anio], ['fijar', false]])->get();
        return response()->json(
            $ingresos,
            200
        );
    }

    public function getTotalFijoMes(Request $request)
    {
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
    }
    public function validarSiTieneIngreso(Request $request)
    {
        $ingresos = Ingreso::where('id_usuario', Auth::user()->id)->count();

        Log::info($ingresos);

        if ($ingresos > 0) {
            return response()->json([
                'tieneIngresos' => true
            ], 200);
        } else {
            return response()->json([
                'tieneIngresos' => false
            ], 200);
        }
    }
}
