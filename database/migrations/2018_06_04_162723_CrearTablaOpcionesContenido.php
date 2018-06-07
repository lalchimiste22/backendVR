<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaOpcionesContenido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opciones_contenido', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('contenido_id');
            $table->text('data');
            $table->unsignedInteger('indice')->default(0);
            $table->boolean('correcto');
            $table->timestamps();

            $table->foreign('contenido_id')->references('id')->on('contenidos');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opciones_contenido');
    }
}
