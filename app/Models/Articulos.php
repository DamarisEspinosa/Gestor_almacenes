<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulos extends Model
{
    use HasFactory;

    protected $fillable = 
        [
            'producto', 
            'cantidad', 
            'descripcion', 
            'almacen_id',
            'proveedor_id'
        ];

    // Relación con el modelo Almacen
    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }
    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
