<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Gasto extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gastos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'desc',
        'monto',
        'dia',
        'mes',
        'anio',
        'fijar',
        'id_usuario',
        'tipo_gasto',
        'subtipo_gasto',
        'mes_termino',
        'anio_termino',
        'ahorro_id'
    ];

    public function getSubTipo(){
        return $this->belongsTo(Subtipos_gasto::class,'subtipo_gasto');
    }
}
