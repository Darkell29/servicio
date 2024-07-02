<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'tipo_servicio',
        'precio_por_unidad',
        'tipo', // Añadir esta línea
        'usuarios_id',
    ];

    public $timestamps = false;
}
