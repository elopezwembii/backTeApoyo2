<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UserTest extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user_tests';

    protected $fillable = [
        'preusers_id',
        'pregunta_id',
        'respuesta_id'
    ];

    public function preuser()
    {
        return $this->belongsTo(Preuser::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class, 'respuesta_id');
    }

}
