<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalidadTipo extends Model
{
    use HasFactory;

    protected $table = 'personalidad';

    protected $fillable = ['tipo', 'descripcion', 'definicion'];

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
    
}
