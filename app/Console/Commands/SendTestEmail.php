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
            $gastosTotal = $user->getGastos()->sum('monto');
            $itemsTotalPresupuestos = 0; // Inicializamos el total de items de presupuestos
    
            $presupuestos = $user->getPresupuestos()->has('getItems')->with('getItems')->get();
    
            foreach ($presupuestos as $presupuesto) {
                $itemsTotalPresupuestos += $presupuesto->getItems->sum('monto');
            }
    
            $porcentajeActual = ($gastosTotal / $itemsTotalPresupuestos) * 100;
            $umbralMinimo = 45; // Puedes ajustar este valor según lo que consideres "cercano al 50%"
            $umbralMaximo80 = 85; // Umbral máximo para 80%

            $cacheKey50 = "email_50_percent_sent_{$user->id}";
            $cacheKey80 = "email_80_percent_sent_{$user->id}";
            
            if ($porcentajeActual >= $umbralMinimo && $porcentajeActual <= 55 && !Cache::get($cacheKey50)) {
                // Envía el correo ya que los gastos están cerca del 50%
                $mensaje = 'gastos totales están llegando a la mitad del presupuesto';
                Cache::put($cacheKey50, true, now()->endOfMonth());  // El cache expira a fin de mes
                Mail::to($user->email)->send(new TestEmail($gastosTotal, $itemsTotalPresupuestos, $user->nombres,$mensaje));
            } elseif ($porcentajeActual > 50 && $porcentajeActual <= $umbralMaximo80) {
                // Envía el correo ya que los gastos están cerca del 80%
                $mensaje = 'gastos totales están llegando a 80% del presupuesto';
                Cache::put($cacheKey50, true, now()->endOfMonth());  // El cache expira a fin de mes
                Mail::to($user->email)->send(new TestEmail($gastosTotal, $itemsTotalPresupuestos, $user->nombres,$mensaje));
            }
        }
    }
    
}
