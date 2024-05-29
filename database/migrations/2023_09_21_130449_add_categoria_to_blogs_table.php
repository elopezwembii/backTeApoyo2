<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Agregar una columna categoria_id para la relación con la tabla CategoriaBlog
            $table->unsignedBigInteger('categoria_id')->nullable();

            // Definir la clave externa para la relación con la tabla CategoriaBlog
            $table->foreign('categoria_id')->references('id')->on('categoriablogs');
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Eliminar la columna categoria_id y la clave externa en caso de reversión
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
        });
    }
};
