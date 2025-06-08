<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /* Catálogo de tipos de contacto */
        Schema::create('tipo_contactos', function (Blueprint $table) {
            $table->id();                 // 1, 2, …
            $table->string('nombre');     // Compras, Pagos…
            $table->timestamps();
        });

        /* Contactos de clientes */
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();

            // FK al cliente (por código ERP)
            $table->string('cliente_codigo');
            $table->foreign('cliente_codigo')
                  ->references('codigo')
                  ->on('clientes')
                  ->cascadeOnDelete();

            // FK al tipo de contacto
            $table->foreignId('tipo_id')
                  ->constrained('tipo_contactos')
                  ->cascadeOnDelete();

            $table->string('nombre');
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contactos');
        Schema::dropIfExists('tipo_contactos');
    }
};
