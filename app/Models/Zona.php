<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zona extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'entregamos'];

    public function localidades(): HasMany
    {
        return $this->hasMany(Localidade::class);
    }
}
