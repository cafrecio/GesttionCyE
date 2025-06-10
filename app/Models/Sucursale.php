<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursale extends Model
{
    protected $fillable = [
        'cliente_id',
        'nombre',
        'calle',
        'numero',
        'provincia_id',
        'localidade_id',
        'zona_id',
        'transporte_sucursale_id',
        'activo',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'codigo');
    }
    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
    public function localidad()
    {
        return $this->belongsTo(Localidade::class);
    }
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
    public function transporte()
    {
        return $this->belongsTo(TransporteSucursale::class, 'transporte_sucursale_id');
    }
}
