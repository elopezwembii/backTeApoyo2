<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs'; // Nombre de la tabla en la base de datos

    // Aquí puedes definir las columnas que son rellenables (fillable) en masa
    protected $fillable = [
        'title',
        'content',
        'imageUrl',
        'date',
    ];

    // Otras propiedades y métodos del modelo, como relaciones, validaciones, etc.
}