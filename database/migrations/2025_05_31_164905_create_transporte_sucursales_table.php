<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transporte_sucursales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transporte_id')->constrained()->cascadeOnDelete();
            $table->string('nombre')->nullable();          // “Depósito Quilmes”
            $table->string('calle');
            $table->string('numero',10);
            $table->foreignId('provincia_id')->constrained('provincias');
            $table->foreignId('localidad_id')->constrained('localidades');
            $table->foreignId('zona_id')->constrained('zonas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transporte_sucursales');
    }
};
