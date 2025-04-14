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
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provincia_id')->constrained('provincias'); // Clave foránea a la tabla provincias
            $table->string('nombre');
            $table->foreignId('zona_id')->constrained('zonas'); // Clave foránea a la tabla zonas, puede ser nula
            $table->timestamps();
            //$table->decimal('latitud', 10, 7)->nullable(); // Para la integración con maps
            //$table->decimal('longitud', 10, 7)->nullable(); // Para la integración con maps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localidades');
    }
};
