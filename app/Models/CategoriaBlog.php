<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaBlog extends Model
{
    use HasFactory;

    protected $table = 'categoriablogs'; // Nombre de la tabla en la base de datos

    // Aquí puedes definir las columnas que son rellenables (fillable) en masa
    protected $fillable = [
        'name',
    ];
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
