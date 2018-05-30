<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPivoteJugadoresRecursoOverrides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jugadores_recurso_overrides', function (Blueprint $table) {
            $table->unsignedInteger('recurso_override_id');
            $table->unsignedInteger('jugador_id');
            $table->timestamps();

            $table->foreign('recurso_override_id')->references('id')->on('recurso_overrides');
            $table->foreign('jugador_id')->references('id')->on('jugadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jugadores_recurso_overrides');
    }
}
