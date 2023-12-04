<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Suscripcion extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'suscripciones';

    protected $fillable = [
        'personas_id', 
        'planes_id', 
        'cupones_id', 
        'fecha_inicio', 
        'fecha_fin', 
        'estado'
    ];

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona', 'personas_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'planes_id');
    }

    public function cupon()
    {
        return $this->belongsTo(Cupon::class, 'cupones_id');
    }

}
