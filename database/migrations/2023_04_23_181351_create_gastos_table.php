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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('desc')->nullable();
            $table->integer('monto');
            $table->integer('dia')->nullable();
            $table->integer('mes')->nullable();
            $table->integer('anio')->nullable();
            $table->boolean('fijar');
            $table->integer('mes_termino')->nullable();
            $table->integer('anio_termino')->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->unsignedBigInteger('tipo_gasto')->nullable();
            $table->unsignedBigInteger('subtipo_gasto')->nullable();

            $table->unsignedBigInteger('ahorro_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
