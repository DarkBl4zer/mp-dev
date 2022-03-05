<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MpPenalesDos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_penales_dos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tipo_formulario');
            $table->bigInteger('agencia_especial')->nullable();
            $table->bigInteger('sinproc')->nullable();
            $table->string('act_sinproc', 255)->nullable();
            $table->boolean('habilitar_archivo')->default(false);
            $table->string('identifica_denunciado', 2);
            $table->integer('tipo_actuacion');
            $table->integer('clase_diligencia');
            $table->integer('estado_audiencia')->nullable();
            $table->integer('criterio_intervencion');
            $table->integer('despacho_judicial');
            $table->string('noticia_criminal', 21);
            $table->integer('delito');
            $table->string('numero_cordis', 13)->nullable();
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
        Schema::dropIfExists('mp_penales_dos');
    }
}
