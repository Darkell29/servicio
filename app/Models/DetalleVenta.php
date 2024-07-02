<?php

// App\Models\DetalleVenta.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_venta';

    protected $fillable = [
        'venta_id', 'servicio_id', 'cantidad', 'precio'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
