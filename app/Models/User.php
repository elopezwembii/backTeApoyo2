<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Log;

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

    public function getPresupuestos()
    {
        return $this->hasMany(Presupuesto::class, 'id_usuario');
    }

    public function calcularNivel()
    {
        $numAreasLlenas = 0;
    
        if ($this->getIngresos()->count() > 0) {
            $numAreasLlenas++;
        }
        if ($this->getPresupuestos()->count() > 0) {
            // Verificar si tiene al menos un ítem de presupuesto
            if ($this->getPresupuestos()->whereHas('getItems')->count() > 0) {
                $numAreasLlenas++;
            }
        }
        if ($this->getDeudas()->count() > 0) {
            $numAreasLlenas++;
        }
        if ($this->getAhorro()->count() > 0) {
            $numAreasLlenas++;
        }
        if ($this->getGastos()->count() > 0) {
            $numAreasLlenas++;
        }
    
        $niveles = [
            0 => 'Novato Financiero',
            1 => 'Money Rookie',
            2 => 'Budget Boss',
            3 => 'Debt Manager',
            4 => 'Expert Saver',
            5 => 'Money Wizard',
        ];
    
        $imagenesPorNivel = [
            'Novato Financiero' => 'https://cdn-icons-png.flaticon.com/512/3830/3830723.png',
            'Money Rookie' => 'https://cdn-icons-png.flaticon.com/512/2695/2695370.png',
            'Budget Boss' => 'https://cdn-icons-png.flaticon.com/512/1903/1903251.png',
            'Debt Manager' => 'https://cdn-icons-png.flaticon.com/512/6823/6823088.png',
            'Expert Saver' => 'https://cdn-icons-png.flaticon.com/512/1141/1141454.png',
            'Money Wizard' => 'https://cdn-icons-png.flaticon.com/512/2579/2579276.png',
        ];
    
        $nivelActual = $niveles[$numAreasLlenas];
        $imagenURL = $imagenesPorNivel[$nivelActual];
    
        // Calcular el siguiente nivel
        $siguienteNivel = isset($niveles[$numAreasLlenas + 1]) ? $niveles[$numAreasLlenas + 1] : null;
    
        return [
            'nivel_actual' => $nivelActual,
            'imagen_url_actual' => $imagenURL,
            'siguiente_nivel' => $siguienteNivel
             ];
    }
    
    
    
}
