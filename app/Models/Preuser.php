<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Preuser extends Model
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'preusers';

    protected $fillable = [
        'email',
        'autoriza'
    ];

    public function tests()
    {
        return $this->hasMany(UserTest::class);
    }
    
}    