<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /** ------------- Clave primaria que viene del ERP ------------- */
    protected $primaryKey = 'codigo';   // no es “id”
    public $incrementing = false;      // no es autoincremental
    protected $keyType = 'string';     // es texto, no número

    /** ------------- Columnas que se pueden actualizar ------------- */
    protected $fillable = [
        'codigo',
        'razon_social_corta',
        'razon_social',
        'cuit',
        'fecha_alta',
        'fecha_ult_fact',
        'estado',
        'moneda',
        'nombre_vendedor',
        'retira',
    ];
    public function contactos()
    {
        return $this->hasMany(Contacto::class, 'cliente_codigo', 'codigo');
    }
    public function sucursales()
    {
        return $this->hasMany(Sucursale::class, 'cliente_id', 'codigo');
    }
    // En Cliente.php (modelo)
    public function getInicialesVendedorAttribute()
    {
        $nombre = $this->nombre_vendedor ?? '';
        if ($nombre == 'MOSTRADOR') return 'MR';
        if ($nombre == 'ING. EDGARDO MELDINI') return 'EM';
        $parts = explode(' ', trim($nombre));
        $iniciales = '';
        foreach ($parts as $p) {
            $iniciales .= strtoupper(mb_substr($p, 0, 1));
        }
        return $iniciales;
    }
}


