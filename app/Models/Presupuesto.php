<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Presupuesto extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'presupuestos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mes',
        'anio',
        'fijado',
        'id_usuario',
    ];

    public function getItems(){
        return $this->hasMany(Item_presupuesto::class,'id_presupuesto');
      }
}
