<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoContacto extends Model
{
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public function contactos()
    {
        return $this->hasMany(Contacto::class, 'tipo_id');
    }
}

