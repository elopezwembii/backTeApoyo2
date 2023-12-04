<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;

use App\Services\MercadoPagoService;
use MercadoPago\SDK;
use MercadoPago;

class PlanController extends Controller
{

    public function __construct(
        private MercadoPagoService $mercadoPagoService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plan = Plan::all();
        return response()->json($plan);
    }

    public function planesFron()
    {
        $plan = Plan::where("promo", 1)->get();
        return response()->json($plan);
    }

    /**
     * Crea los planes para suscripciones.
     */
    public function crearPlanes(Request $request)
    {
        if ($request->has('percentage')) {
            $percentage = $request->input('percentage');

            $transaction = $request->input('transaction_amount');
            $discount = round(($transaction * $percentage) / 100);
            $transaction_amount = round($transaction - $discount);
        } else {
            $percentage = 0;
            $transaction_amount = $request->input('transaction_amount');
        }

        $request->merge(['transaction_amount' => $transaction_amount]);

        $plan = $this->mercadoPagoService->crearPlan($request);

        if($plan->original['status'] == "active"){
            //guardar en base de datos
            
            $codigo = '';
            if($request->state_cupon == 1){
                $length = 8;
                $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $charactersLength = strlen($characters);
                for ($i = 0; $i < $length; $i++) {
                    $codigo .= $characters[rand(0, $charactersLength - 1)];
                }
            }
            
            $resp = Plan::create([
                'uid' => $plan->original['id'],//este es el preapproval_plan_id
                'frequency' => $plan->original['auto_recurring']['frequency'],
                'frequency_type' => $plan->original['auto_recurring']['frequency_type'],
                'repetitions' => isset($plan->original['auto_recurring']['repetitions']) ? $plan->original['auto_recurring']['repetitions'] : null,
                'billing_day' => $plan->original['auto_recurring']['billing_day'],
                'billing_day_proportional' => $plan->original['auto_recurring']['billing_day_proportional'],
                'frequency_free' => $plan->original['auto_recurring']["free_trial"]['frequency'],
                'frequency_type_free' => $plan->original['auto_recurring']["free_trial"]['frequency_type'],
                'first_invoice_offset' => $plan->original['auto_recurring']['free_trial']['first_invoice_offset'],
                'transaction_amount' => $plan->original['auto_recurring']['transaction_amount'],
                'cupon' => $request->cupon ? $request->cupon : $codigo,
                'percentage' => $percentage,
                'state_cupon' => $request->state_cupon,
                'currency_id' => $plan->original['auto_recurring']['currency_id'],
                'reason' => $plan->original['reason'],
                'empresa_id' => $request->empresa_id ? $request->empresa_id : 0,
                'status' => $plan->original['status']
            ]);
            return response()->json($resp);
        }else{
            return response()->json($plan); 
        }     
    }

    /**
     * NO usado
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'precio_mensual' => 'required',
            'precio_anual' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $plan = new Plan;
        $plan->nombre = $request->nombre;
        $plan->precio_mensual = $request->precio_mensual;
        $plan->precio_anual = $request->precio_anual;
        $plan->save();

        return response()->json(['success' => 'Plan creado exitosamente.', 'plan' => $plan], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * buscar planes
     */
    public function search(Request $request, $go)
    {
        return $this->mercadoPagoService->buscarPlanes($go);
    }

    /**
     * sincronizar
     */
    public function sincronizar(Request $request, $go)
    {
        $array = $this->mercadoPagoService->buscarPlanes($go);
        $array = $array->getData(true);
        
        foreach ($array['results'] as $result) {
            if ($result['status'] == 'active') {
                Plan::updateOrCreate(
                    ['uid' => $result['id']],
                    [
                        'reason' => $result['reason'],
                        'status' => $result['status'],
                        'frequency' => $result['auto_recurring']['frequency'],
                        'currency_id' => $result['auto_recurring']['currency_id'],
                        'transaction_amount' => $result['auto_recurring']['transaction_amount'],
                        'frequency_type' => $result['auto_recurring']['frequency_type'],
                    ]
                );
            }
        }

        return $array;
    }

    /**
     * Actualiza el plan en la base de dfatos
     * y en cuenta mercado pago
     */
    public function update(Request $request)
    {
        ////este es el preapproval_plan_id es $request->id
        $tag = Plan::findOrFail($request->id);
        $request->request->add(["uid" => $tag->uid]);

        if ($request->has('percentage')) {
            $percentage = $request->input('percentage');

            $transaction = $request->input('transaction_amount');
            $discount = round(($transaction * $percentage) / 100);
            $transaction_amount = round($transaction - $discount);
        } else {
            $percentage = 0;
            $transaction_amount = $request->input('transaction_amount');
        }
        $request->merge([
            'transaction_amount' => $transaction_amount
        ]);

        ///dd($request->toArray());

        ////salida de mercado pago
        $plan = $this->mercadoPagoService->actualizarPlan($request);

        if($plan->original && $plan->original['status'] === 400){
            //se actualiza la bd a pesar que mercado pago no actualiza la frecuencia
            //esto es temporal mientras mercado pago responde a las preguntas formuladas
            $tag->update([
                'frequency' => $request->frequency,
                'frequency_type' => $request->frequency_type,
                'repetitions' => $request->repetitions !== null ? $request->repetitions : $tag->repetitions,
                'billing_day' => $request->billing_day,
                'billing_day_proportional' => $request->billing_day_proportional,
                'frequency_free' => $request->frequency_free,
                'frequency_type_free' => $request->frequency_type_free,
                'transaction_amount' => $request->transaction_amount,
                'cupon' => $request->cupon !== null ? $request->cupon : $tag->cupon,
                'percentage' =>  $request->percentage !== null ? $request->percentage : $tag->percentage,
                'state_cupon' => $request->state_cupon ? $request->state_cupon : 0,
                'currency_id' => $request->currency_id,
                'reason' => $request->reason,
                'empresa_id' => $request->empresa_id ? $request->empresa_id : 0,
                'status' => "active"
            ]);
            return response()->json($plan); 
        } else if ($plan->original['status'] === 'active') {
            //Plan agregado correctamente
            $tag->update([
                'frequency' => $request->frequency,
                'frequency_type' => $request->frequency_type,
                'repetitions' => $request->repetitions !== null ? $request->repetitions : $tag->repetitions,
                'billing_day' => $request->billing_day,
                'billing_day_proportional' => $request->billing_day_proportional,
                'frequency_free' => $request->frequency_free,
                'frequency_type_free' => $request->frequency_type_free,
                'transaction_amount' => $request->transaction_amount,
                'cupon' => $request->cupon !== null ? $request->cupon : $tag->cupon,
                'percentage' =>  $request->percentage !== null ? $request->percentage : $tag->percentage,
                'state_cupon' => $request->state_cupon,
                'currency_id' => $request->currency_id,
                'reason' => $request->reason,
                'empresa_id' => $request->empresa_id ? $request->empresa_id : 0,
                'status' => $request->status
            ]);

            return response()->json(
                $tag,
                200
            );
        }else{
            //Error desconocido"
            return response()->json($plan); 
        }
        
        /*
        if($plan->original['status'] == "active"){
            if ($tag) {
                $tag->update([
                    'frequency' => $request->frequency,
                    'frequency_type' => $request->frequency_type,
                    'repetitions' => $request->repetitions !== null ? $request->repetitions : $tag->repetitions,
                    'billing_day' => $request->billing_day,
                    'billing_day_proportional' => $request->billing_day_proportional,
                    'frequency_free' => $request->frequency_free,
                    'frequency_type_free' => $request->frequency_type_free,
                    'transaction_amount' => $request->transaction_amount,
                    'cupon' => $request->cupon !== null ? $request->cupon : $tag->cupon,
                    'percentage' =>  $request->percentage !== null ? $request->percentage : $tag->percentage,
                    'state_cupon' => $request->state_cupon,
                    'currency_id' => $request->currency_id,
                    'reason' => $request->reason,
                    'empresa_id' => $request->empresa_id ? $request->empresa_id : 0,
                    'status' => $request->status
                ]);

                return response()->json(
                    $tag,
                    200
                );
                
            } else {
                return response()->json(
                    ['error'=>"No se encontró el plan"],
                    404
                );
            }
        }else{
            return response()->json($plan); 
        } */    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $plan = Plan::find($request->id);
        if ($plan) {
            $plan->delete();
            return response()->json(
                $plan,
                200
            );
        } else {
            return response()->json(
                ['error'=>"No se encontró un plan con el uid " . $request->uid],
                404
            );
        }
    }

    /**
     * Selecciona plan para ser usado en en la web
     */
    public function promoUp(Request $request)
    {
        $plan = Plan::findOrFail($request->id);
        
        if ($request->promo == 1) {
            $count = Plan::where("promo", 1)->count();
            if ($count >= 2) {
                return response()->json([
                    "code" => 400,
                    "message" => "Cupo máximo para la web"
                ]);
            }
        }

        $plan->update(['promo' => $request->promo]);

        return response()->json([
            "code" => 200,
            "message" => "Ok"
        ]);
    }

}
