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
        Schema::create('ahorros', function (Blueprint $table) {
            $table->id();
            $table->string('desc')->nullable();
            $table->integer('meta');
            $table->integer('recaudado');
            $table->date('fecha_limite');
            $table->integer('tipo_ahorro');
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahorros');
    }
};
