<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Item_presupuesto extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'item_presupuestos';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'monto',
        'id_presupuesto',
        'tipo_gasto',
    ];


}
