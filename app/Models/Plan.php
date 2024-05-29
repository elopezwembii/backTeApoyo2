<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Plan extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'planes';

    protected $fillable = [
        'uid',
        'frequency',
        'frequency_type',
        'repetitions',
        'billing_day',
        'billing_day_proportional',
        'frequency_free',
        'frequency_type_free',
        'first_invoice_offset',
        'transaction_amount',
        'cupon',
        'percentage',
        'state_cupon',
        'currency_id',
        'reason',
        'empresa_id',
        'promo',
        'status'
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
