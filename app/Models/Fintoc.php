<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Fintoc extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'fintoc';

    protected $fillable = [
        'personas_id', 
        'planes_id', 
        'cupones_id', 
        'fecha_inicio', 
        'fecha_fin', 
        'estado'
    ];

}
