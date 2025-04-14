<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Localidade extends Model
{
    use HasFactory;

    protected $fillable = ['provincia_id', 'nombre', 'zona_id'];

    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }
}