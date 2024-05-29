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
        Schema::create('tarjetas', function (Blueprint $table) {
            $table->id();
            $table->integer('total');
            $table->integer('utilizado');
            $table->enum('tipo',['Línea de crédito','Tarjeta de crédito']);
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_banco');
            $table->timestamps();
            $table->foreign('id_usuario')->references('id')->on('usuarios');
            $table->foreign('id_banco')->references('id')->on('bancos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarjetas');
    }
};
