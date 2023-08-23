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
        Schema::table('gastos', function (Blueprint $table) {
            $table->foreign('id_usuario')->references('id')->on('usuarios');
            $table->foreign('tipo_gasto')->references('id')->on('tipos_gastos');
            $table->foreign('subtipo_gasto')->references('id')->on('subtipos_gastos');

            $table->foreign('ahorro_id')->references('id')->on('ahorros');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
