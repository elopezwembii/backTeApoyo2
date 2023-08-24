<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail; 
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
        $users = User::where('nombres', 'Mauricio')->get();
    
        foreach ($users as $user) {
            $gastosTotal = $user->getGastos()->sum('monto');
            $itemsTotalPresupuestos = 0; // Inicializamos el total de items de presupuestos
    
            $presupuestos = $user->getPresupuestos()->has('getItems')->with('getItems')->get();
    
            foreach ($presupuestos as $presupuesto) {
                $itemsTotalPresupuestos += $presupuesto->getItems->sum('monto');
            }
    
            $porcentajeActual = ($gastosTotal / $itemsTotalPresupuestos) * 100;
            $umbralMinimo = 45; // Puedes ajustar este valor según lo que consideres "cercano al 50%"
            Log::info($porcentajeActual);
    
            if ($porcentajeActual >= $umbralMinimo && $porcentajeActual <= 55) {
                // Envía el correo ya que los gastos están cerca del 50%
                Mail::to("cesar.troncoso@ssantofagasta.cl")->send(new TestEmail($gastosTotal, $itemsTotalPresupuestos, $user->nombres));
                Log::info('Correo de prueba enviado con éxito.');
            } else {
                Log::info('Gastos no están cerca del 50%.');
            }
        }
    }
    
}
