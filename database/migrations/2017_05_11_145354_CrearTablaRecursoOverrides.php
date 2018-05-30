<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaRecursoOverrides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurso_overrides', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recurso_id');
            $table->unsignedInteger('user_id');
            $table->string('nombre');
            $table->text('descripcion');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('recurso_id')->references('id')->on('recursos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recurso_overrides');
    }
}
