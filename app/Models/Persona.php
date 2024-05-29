<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Persona extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'personas';

    protected $fillable = [
        'nombre', 
        'apellido', 
        'email', 
        'tipo_usuario', 
        'empresa',
        'api_token',
        'status'
    ];

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }
}
