<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->string('codigo')->primary();          // ID del ERP
            $table->string('razon_social_corta');
            $table->string('razon_social');
            $table->string('cuit', 11);
            $table->date('fecha_alta')->nullable();
            $table->date('fecha_ult_fact')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->string('moneda', 5)->nullable();
            $table->string('nombre_vendedor')->nullable();
            $table->boolean('retira')->default(false);    // false = entregamos
            $table->timestamps();                         // crea created_at / updated_at
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
