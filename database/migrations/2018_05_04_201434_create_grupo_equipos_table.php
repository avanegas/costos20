<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupoEquiposTable extends Migration
{
    public function up()
    {
        Schema::create('grupo_equipos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('zona_id')->unsigned();
            $table->string('name')->unique();
            $table->mediumText('description');

            //relation
            $table->foreign('zona_id')->references('id')->on('zonas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grupo_equipos');
    }
}
