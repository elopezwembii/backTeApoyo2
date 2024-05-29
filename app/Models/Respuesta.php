<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Respuesta extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'respuestas';

    protected $fillable = [
        'pregunta_id',
        'respuesta',
        'personalidad_tipo',
        'personalidad_tipo_id'
    ];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    public function personalidadTipo()
    {
        return $this->belongsTo(PersonalidadTipo::class);
    }

}
