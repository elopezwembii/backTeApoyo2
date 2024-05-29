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
        Schema::create('cupones', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('descripcion');
            $table->float('descuento');
            $table->enum('tipo', ['individual', 'colectivo'])->default('individual');
            $table->enum('periocidad', ['mensual', 'anual'])->default('anual');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('planes_id');
            $table->integer('empresa_id')->default(0);
            $table->integer('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupones');
    }
};
