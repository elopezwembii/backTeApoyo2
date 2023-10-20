<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use App\Mail\InactiveUserEmail; 
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Command;

class SendInactiveUserEmails extends Command
{
    protected $signature = 'email:send-inactive-users';
    protected $description = 'Envía correos a los usuarios inactivos';

     
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $inactiveUsers = User::where('last_login_at', '<', now()->subDays(30))->get();
        foreach ($inactiveUsers as $user) {
            $cacheKey = "email_inactive_sent_{$user->id}";
    
            // Verifica si no existe una entrada en el caché para ese usuario
            if (!Cache::get($cacheKey)) {
                Mail::to($user->email)->send(new InactiveUserEmail($user->nombres)); 
    
                // Guarda un valor en el caché para ese usuario indicando que un correo ha sido enviado
                // Podemos establecer la expiración del caché a 30 días, de esta manera el sistema intentará
                // enviar nuevamente después de un mes si el usuario sigue siendo inactivo
                Cache::put($cacheKey, true, now()->addDays(30));
            }
        }
    }
    
}
