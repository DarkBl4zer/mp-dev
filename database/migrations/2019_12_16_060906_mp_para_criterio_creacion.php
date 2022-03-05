<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MpParaCriterioCreacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_para_criterio_creacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('valor');
            $table->string('nombre', 550);
            $table->boolean('eliminado')->default(false);
            $table->bigInteger('usuario_crea');
            $table->bigInteger('usuario_modifica')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mp_para_criterio_creacion');
    }
}
