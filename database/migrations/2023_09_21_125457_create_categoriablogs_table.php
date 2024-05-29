<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriablogsTable extends Migration
{
    public function up()
    {
        Schema::create('categoriablogs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Agrega un campo 'name' para el nombre de la categoría
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categoriablogs');
    }
}
