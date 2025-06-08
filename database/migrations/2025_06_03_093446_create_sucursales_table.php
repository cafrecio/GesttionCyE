<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id();
            $table->string('cliente_id'); // string porque viene del ERP y no siempre es entero
            $table->string('nombre');
            $table->string('calle');
            $table->string('numero')->nullable();
            $table->foreignId('provincia_id')->constrained('provincias');
            $table->foreignId('localidade_id')->constrained('localidades');
            $table->foreignId('zona_id')->constrained('zonas');
            $table->foreignId('transporte_sucursale_id')->nullable()->constrained('transporte_sucursales');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};

