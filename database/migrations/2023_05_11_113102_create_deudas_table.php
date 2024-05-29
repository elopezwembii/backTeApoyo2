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
        Schema::create('deudas', function (Blueprint $table) {
            $table->id();
            $table->string('desc')->nullable();
            $table->integer('saldada');
            $table->integer('costo_total')->nullable();
            $table->integer('deuda_pendiente');
            $table->integer('cuotas_totales');
            $table->integer('cuotas_pagadas');
            $table->integer('pago_mensual');
            $table->integer('dia_pago');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_banco');
            $table->unsignedBigInteger('id_tipo_deuda');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('usuarios');
            $table->foreign('id_banco')->references('id')->on('bancos');
            $table->foreign('id_tipo_deuda')->references('id')->on('tipos_deudas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudas');
    }
};
