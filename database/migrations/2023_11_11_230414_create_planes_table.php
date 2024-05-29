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
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->integer('frequency')->default(1);
            $table->string('frequency_type')->nullable();
            $table->unsignedBigInteger('repetitions')->nullable();
            $table->integer('billing_day')->default(1);
            $table->boolean('billing_day_proportional');
            $table->integer('frequency_free')->default(0);
            $table->string('frequency_type_free')->nullable();
            $table->integer('first_invoice_offset')->default(0);
            $table->float('transaction_amount');
            $table->string('cupon')->nullable();
            $table->float('percentage');
            $table->integer('state_cupon')->default(0);
            $table->string('currency_id')->nullable();
            $table->string('reason')->nullable();
            $table->integer('empresa_id')->default(0);
            $table->string('tipo')->nullable();
            $table->integer('promo')->default(0);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};