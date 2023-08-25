<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use App\Mail\InactiveUserEmail; 
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
            Mail::to("cesar.troncoso@ssantofagasta.cl")->send(new InactiveUserEmail($user->nombres));//$user->email
        }

    }
}
