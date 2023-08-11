<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Empresa extends Model
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'estado',
        'cantidad_colaboradores',
        'id_admin'

    ];

    public function getEncargado()
    {
        return $this->hasMany(User::class, 'id', 'id_admin');
    }

    public function getCantidadColaboradores()
    {
        // Obtén la cantidad de colaboradores asociados a la empresa
        return $this->hasMany(User::class, 'id_empresa')->count();
    }
}
