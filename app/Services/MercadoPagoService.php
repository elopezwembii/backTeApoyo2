<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\Plan;
use MercadoPago\Subscription;
//use MercadoPago\SDK;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService {

    private $token;
    private $url;
    private $back_url;
    private $back_url2;
    /*
        [
            "success" => "https://www.te-apoyo.com/exito",
            "pending" => "https://www.te-apoyo.com/pendiente",
            "failure" => "https://www.te-apoyo.com/fallo"
        ]

        $this->back_url2 = "https://www.te-apoyo.com/exito"; 
    */

    public function __construct(){
        
        //SDK::setAccessToken(config('mercadopago.access_token'));
        MercadoPagoConfig::setAccessToken(config('mercadopago.access_token'));
        $this->token = config('mercadopago.access_token');
        $this->url = 'https://api.mercadopago.com';
        $this->back_url = [
            "success" => "https://www.te-apoyo.com",
            "pending" => "https://www.te-apoyo.com",
            "failure" => "https://www.te-apoyo.com"
        ];
        $this->back_url2 = "https://www.te-apoyo.com";     
            
    }

    public function crearPreferencia(Request $request){

        if($request->modoPago == 'concupon'){
            $precio = $request->precioCupon;
        }else{
            $precio = $request->precioSuscripcion;
        }
        
        $resp = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ])->post($this->url . '/checkout/preferences', [
            "back_urls" => $this->back_url,
            "expires" => false,
            "items" => [
                [
                    "title" => 'Plan Individual ' . $request->tipoSuscripcion,
                    "description" => 'Suscripcion ' . $request->tipoSuscripcion,
                    "quantity" => 1,
                    "currency_id" => "CL",
                    "unit_price" => $precio
                ]
            ]
        ]);

        return response()->json($resp->json());

    }

    public function obtenerPago() {
        // Consultar por la preferencia...
    }


    public function crearPlan(Request $request)
    {
        $auto_recurring = [
            'auto_recurring' => [
                'frequency' => (int)$request->frequency,
                'frequency_type' => $request->frequency_type,
                'billing_day' => $request->billing_day,
                'billing_day_proportional' => $request->billing_day_proportional,
                'free_trial' => [
                    'frequency' => (int)$request->frequency_free,
                    'frequency_type' => $request->frequency_type_free
                ],
                'transaction_amount' => $request->transaction_amount,
                'currency_id' => 'CLP'
            ],
            "back_url" => $this->back_url2,
            'reason' => $request->reason
        ];

        if ($request->has('repetitions')) {
            $auto_recurring['auto_recurring']['repetitions'] = $request->repetitions;
        }

        $resp = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ])->post($this->url . '/preapproval_plan', $auto_recurring);

        return response()->json($resp->json());
    }

    public function actualizarPlan(Request $request)
    {

        $resp = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ])->put($this->url . '/preapproval_plan/' . $request->uid, [
            'auto_recurring' => [
                'frequency' => $request->frequency,
                'frequency_type' => $request->frequency_type,
                'repetitions' => $request->repetitions,
                'billing_day' => $request->billing_day,
                'billing_day_proportional' => $request->billing_day_proportional,
                'free_trial' => [
                    'frequency' => $request->frequency_free,
                    'frequency_type' => $request->frequency_type_free
                ],
                'transaction_amount' => $request->transaction_amount,
                'currency_id' => 'CLP'
            ],
            'back_url' => $this->back_url2,
            'reason' => $request->reason
        ]);

        return response()->json($resp->json());
    }

    public function buscarPlanes($go){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ])->get($this->url . '/preapproval_plan/search', ['q' => $go, 'limit' => 100]);
        
        return response()->json($response->json());
    }

    public function crearSuscripcion(){

        $resp = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ])->post($this->url . '/preapproval', [
            'auto_recurring' => [
                'frequency' => $request->frequency,
                'frequency_type' => $request->frequency_type,
                'start_date' => '2020-06-02T13:07:14.260Z',
                'end_date' => '2022-07-20T15:59:52.581Z',
                'transaction_amount' => $request->transaction_amount,
                'currency_id' => 'CLP'
            ],
            'back_url' => $this->back_url,
            'card_token_id' => 'e3ed6f098462036dd2cbabe314b9de2a',
            'external_reference' => 'YG-1234',
            'payer_email' => 'test_user@testuser.com',
            'preapproval_plan_id' => '2c938084726fca480172750000000000',
            'reason' => $request->reason,
            'status' => 'authorized'
        ]);

        return response()->json($resp->json());
    }

    public function obtenerSuscripcion(){

        return Subscription::find_by_id("YOUR_SUBSCRIPTION_ID");
    }

}