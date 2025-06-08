<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'cliente_codigo',   // FK textual
        'tipo_id',             // 1 = Compras, 2 = Cobranzas
        'nombre',
        'apellido',
        'email',
        'telefono',
    ];

    /*  Cada contacto PERTENECE a un cliente  */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_codigo', 'codigo');
    }
    public function tipo()
    {
        return $this->belongsTo(TipoContacto::class,'tipo_id');
    }
}

