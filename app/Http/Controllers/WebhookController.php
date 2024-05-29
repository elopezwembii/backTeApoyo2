<?php

namespace App\Http\Controllers;
use Log;
use Illuminate\Http\Request;
use App\Http\Requests;
use Http;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {     
        $resp = $request->all();

        if($resp->status == "authorized"){
            //authorized: Suscripción con un método de pago

            //pagador
            $pagador = $resp->payer_id;

        }else{
            //pending: Suscripción sin método de pago

            //pagador
            $pagador = $resp->payer_id;

        }

    }
}