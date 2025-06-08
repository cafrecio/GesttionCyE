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
        Schema::table('transporte_sucursales', function (Blueprint $table) {
            $table->boolean('activo')->default(true)->after('zona_id');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('transporte_sucursales', function (Blueprint $table) {
            $table->dropColumn('activo');
        });
    }
};
