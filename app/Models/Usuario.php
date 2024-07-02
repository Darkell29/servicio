<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'usuario', 'contraseña', 'rol',
    ];

    protected $hidden = [
        'contraseña', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['contraseña'] = bcrypt($password);
    }

    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}
