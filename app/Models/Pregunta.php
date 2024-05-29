<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Pregunta extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'preguntas';

    protected $fillable = [
        'pregunta'
    ];

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
}
