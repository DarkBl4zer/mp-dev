<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MpEnteramiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_enteramiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_tipo_mp');
            $table->integer('cantidad');
            $table->string('unidad');
            $table->string('archivo_dt')->nullable();
            $table->string('archivo_or')->nullable();
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
        Schema::dropIfExists('mp_enteramiento');
    }
}
