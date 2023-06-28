<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Ingreso extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ingresos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'desc',
        'monto_real',
        'dia',
        'mes',
        'anio',
        'fijar',
        'id_usuario',
        'tipo_ingreso',
        'mes_termino',
        'anio_termino'
    ];
}
