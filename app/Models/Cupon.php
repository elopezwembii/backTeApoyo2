<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Cupon extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'cupones';

    protected $fillable = [
        'codigo', 
        'descripcion', 
        'descuento', 
        'tipo', 
        'periocidad',
        'fecha_inicio', 
        'fecha_fin',
        'planes_id',
        'empresa_id',
        'estado'
    ];

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa', 'empresa_id');
    }
}
