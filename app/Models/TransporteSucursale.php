<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransporteSucursale extends Model
{
    protected $fillable = [
        'transporte_id', 'nombre', 'calle', 'numero',
        'provincia_id', 'localidad_id', 'zona_id', 'activo'
    ];

    public function transporte() { return $this->belongsTo(Transporte::class); }
    public function provincia()  { return $this->belongsTo(Provincia::class);  }
    public function localidad()  { return $this->belongsTo(Localidade::class); }
    public function zona()       { return $this->belongsTo(Zona::class);       }
    
}
