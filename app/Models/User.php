<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estado',
        'intentos',
        'rut',
        'nombres',
        'apellidos',
        'genero',
        'nacionalidad',
        'fecha_nacimiento',
        'ciudad',
        'direccion',
        'telefono',
        'email',
        'avatar',
        'password',
        'perfil_financiero',
        'suscripcion_inicio',
        'suscripcion_fin',
        'primera_guia',
        'id_empresa',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario', 'id_usuario', 'id_rol')->select(['nombre'])->withTimestamps();
    }

    public function hijos()
    {
        return $this->belongsToMany(User::class, 'hijos', 'id_usuario', 'id_hijo')->withTimestamps();
    }


    public function getIngresos()
    {
        return $this->hasMany(Ingreso::class, 'id_usuario');
    }

    public function getGastos()
    {
        return $this->hasMany(Gasto::class, 'id_usuario');
    }

    public function getDeudas()
    {
        return $this->hasMany(Deuda::class, 'id_usuario');
    }
    public function getTarjetas()
    {
        return $this->hasMany(Tarjeta::class, 'id_usuario');
    }
    public function getAhorro()
    {
        return $this->hasMany(Ahorro::class, 'id_usuario');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa'); // Cambia "Empresa" al nombre de tu modelo de empresa
    }
    
}
