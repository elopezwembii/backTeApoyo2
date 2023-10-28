<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail; 
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


class SendTestEmail extends Command
{
    protected $signature = 'email:test';
    protected $description = 'Envía un correo de prueba';

   
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
       // $users = User::where('nombres', 'Cesar')->get();

        $usersAll=User::all();
    
        foreach ($usersAll as $user) {
            $gastosTotal = $user->getGastosActual()->sum('monto');
            $itemsTotalPresupuestos = 0; // Inicializamos el total de items de presupuestos
    
            $presupuestos = $user->getPresupuestosActual()->has('getItems')->with('getItems')->get();
    
            foreach ($presupuestos as $presupuesto) {
                $itemsTotalPresupuestos += $presupuesto->getItems->sum('monto');
            }
    
            if ($itemsTotalPresupuestos == 0) {
                // Puedes continuar con la siguiente iteración del bucle, 
                // o manejar este caso de alguna otra forma que consideres adecuada.
                continue; 
            }

            Log::info("total gasto".$gastosTotal);
            Log::info("total presupuesto".$itemsTotalPresupuestos);
            
            $porcentajeActual = ($gastosTotal / $itemsTotalPresupuestos) * 100;

            Log::info("porcetaje actual".$porcentajeActual);
            
            $umbralMinimo = 51; // Puedes ajustar este valor según lo que consideres "cercano al 50%"
            $umbralMaximo = 90; // Umbral máximo para 80%

            $cacheKey50 = "email_50_percent_sent_{$user->id}";
            $cacheKey80 = "email_80_percent_sent_{$user->id}";
           
            Log::info("c50".Cache::get($cacheKey50));
            Log::info("c80".Cache::get($cacheKey80));
           Log::info("usuario".$user->email);

            if ($porcentajeActual <= $umbralMinimo && $porcentajeActual>=40 && !Cache::get($cacheKey50) ) {//&& !Cache::get($cacheKey50)
                // Envía el correo ya que los gastos están cerca del 50%
                Log::info('entro mitad'.$user->email);
                $mensaje = 'han sobrepasado el 50%';//
                Cache::put($cacheKey50, true, now()->addDays(3));//Cache::put($cacheKey50, true, now()->endOfMonth());  // El cache expira a fin de mes
                Mail::to($user->email)->send(new TestEmail($gastosTotal, $itemsTotalPresupuestos, $user->nombres,$mensaje));
            } elseif ($porcentajeActual > 70 && $porcentajeActual <= $umbralMaximo && !Cache::get($cacheKey80) ) {//&& !Cache::get($cacheKey80)
                // Envía el correo ya que los gastos están cerca del 80%
                $mensaje = 'han sobrepasado el 80%';
                Log::info('entro 80'.$user->email);
          
                Cache::put($cacheKey80, true, now()->addDays(3));//Cache::put($cacheKey80, true, now()->endOfMonth());  // El cache expira a fin de mes
                Mail::to($user->email)->send(new TestEmail($gastosTotal, $itemsTotalPresupuestos, $user->nombres,$mensaje));
            }
        }
    }
    
}

     //Cache::flush();