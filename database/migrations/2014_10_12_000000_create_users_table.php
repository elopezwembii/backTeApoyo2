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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->integer('estado');
            $table->integer('intentos');
            $table->string('rut', 255)->nullable();
            $table->string('nombres', 255)->nullable();
            $table->string('apellidos', 255)->nullable();
            $table->enum('genero',['Masculino','Femenino','Otro', 'No definido'])->nullable();
            $table->string('nacionalidad')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono', 255)->nullable();
            $table->string('email')->unique();
            $table->string('avatar', 255)->nullable();
            $table->string('password');
            $table->string('perfil_financiero', 255)->nullable();

            $table->date('suscripcion_inicio')->nullable();
            $table->date('suscripcion_fin')->nullable();

            $table->integer('primera_guia');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->unsignedBigInteger('id_empresa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
