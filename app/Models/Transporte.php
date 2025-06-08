<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
    protected $fillable = ['razon_social', 'activo'];

    /* relación: un transporte tiene muchas sucursales (direcciones) */
    public function sucursales()
    {
        return $this->hasMany(TransporteSucursale::class);
    }
}