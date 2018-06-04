<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaContenidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenidos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recurso_id');
            $table->string('tipo');
            $table->text('data');
            $table->unsignedInteger('indice')->default(0);

            $table->foreign('recurso_id')->references('id')->on('recursos');
            $table->softDeletes();
        });

        //Crear un contenido "default" para los recursos ya existentes
        /*$recursos = \App\Recurso::all();

        foreach($recursos as $r)
        {
            //@TODO
        }*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contenidos');
    }
}
