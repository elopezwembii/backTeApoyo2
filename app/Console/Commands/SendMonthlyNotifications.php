<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\MonthlyNotificationEmail; 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendMonthlyNotifications extends Command
{
    protected $signature = 'email:send-monthly-notifications';
    protected $description = 'Envía notificaciones mensuales a los usuarios';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $users = User::where('nombres', 'Cesar')->get();
        Log::info($users);

        $usersAll = User::all();
        $currentDate = now();

        foreach ($users as $user) {
            // Verifica si es el principio, mitad o fin de mes
            $dayOfMonth = $currentDate->day;
            $message = 'nada';

            if ($dayOfMonth <= 10) {
                $message = 'principios de mes';
            } elseif ($dayOfMonth <= 20) {
                $message = 'mitad del mes';
            } else {
                $message = 'final del mes';
            }

            // Envía el correo de notificación
            Mail::to("cesar.troncoso.vergara@gmail.com")->send(new MonthlyNotificationEmail( $user->nombres,$message));//$user->email
            Log::info('Correo de notificación mensual enviado con éxito.');
        }
    }
}