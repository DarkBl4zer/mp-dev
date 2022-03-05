<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MpPolicivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_policivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tipo_formulario');
            $table->bigInteger('id_tipo_mp');
            $table->bigInteger('sinproc')->nullable();
            $table->string('act_sinproc', 255)->nullable();
            $table->boolean('habilitar_archivo')->default(false);
            $table->integer('tipo_actuacion');
            $table->integer('clase_diligencia');
            $table->integer('despacho_judicial')->nullable();
            $table->integer('estado_audiencia')->nullable();
            $table->string('numero', 255)->nullable();
            $table->string('numero_cordis', 23)->nullable();
            $table->integer('clase')->nullable();
            $table->integer('autoridad')->nullable();
            $table->date('fecha_actuacion');
            $table->longText('observaciones');
            $table->string('archivo_dt', 255)->nullable();
            $table->string('archivo_or', 255)->nullable();
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
        Schema::dropIfExists('mp_policivos');
    }
}
