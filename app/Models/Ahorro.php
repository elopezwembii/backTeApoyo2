<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Ahorro extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'desc',
        'meta',
        'recaudado',
        'fecha_limite',
        'tipo_ahorro',
        'id_usuario',
    ];

    public function gastos()
{
    return $this->hasMany(Gasto::class, 'ahorro_id');
}

}

