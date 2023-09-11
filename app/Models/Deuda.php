<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Deuda extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'desc',
        'saldada',
        'costo_total',
        'deuda_pendiente',
        'cuotas_totales',
        'cuotas_pagadas',
        'pago_mensual',
        'dia_pago',
        'id_usuario',
        'id_banco',
        'id_tipo_deuda'
    ];


    public function gastos()
{
    return $this->hasMany(Gasto::class, 'deuda_id');
}

}
