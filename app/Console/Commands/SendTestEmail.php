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
            $umbralMaximo80 = 85; // Umbral máximo para 80%
    
            if ($porcentajeActual >= $umbralMinimo && $porcentajeActual <= 55) {
                // Envía el correo ya que los gastos están cerca del 50%
                $mensaje = 'gastos totales están llegando a la mitad del presupuesto';
                Mail::to("cesar.troncoso@ssantofagasta.cl")->send(new TestEmail($gastosTotal, $itemsTotalPresupuestos, $user->nombres,$mensaje));
            } elseif ($porcentajeActual > 50 && $porcentajeActual <= $umbralMaximo80) {
                // Envía el correo ya que los gastos están cerca del 80%
                $mensaje = 'gastos totales están llegando a 80% del presupuesto';
                Mail::to("cesar.troncoso@ssantofagasta.cl")->send(new TestEmail($gastosTotal, $itemsTotalPresupuestos, $user->nombres,$mensaje));
            }
        }
    }
    
}
