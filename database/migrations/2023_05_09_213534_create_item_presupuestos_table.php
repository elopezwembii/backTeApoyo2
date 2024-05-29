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
        Schema::create('item_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->integer('monto');
            $table->unsignedBigInteger('id_presupuesto');
            $table->unsignedBigInteger('tipo_gasto');
            $table->timestamps();

            $table->foreign('id_presupuesto')->references('id')->on('presupuestos');
            $table->foreign('tipo_gasto')->references('id')->on('tipos_gastos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_presupuestos');
    }
};
