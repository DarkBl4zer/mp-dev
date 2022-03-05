<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MpAgenciaInformes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_agencia_informes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_agencia_especial');
            $table->integer('numero_agencia_especial');
            $table->date('fecha_informe');
            $table->integer('id_periodo_reportado');
            $table->string('periodo_reportado', 255);
            $table->bigInteger('tipo_victima');
            $table->longText('actuacion_procesal');
            $table->string('datos_victima', 5);
            $table->string('corregir_delito', 5);
            $table->string('dato_indiciado', 5);
            $table->string('fin_ae', 5);
            $table->bigInteger('nuevo_delito')->nullable();
            $table->bigInteger('nuevo_despacho')->nullable();
            $table->string('nombre_indiciado', 255)->nullable();
            $table->bigInteger('indentificacion_indiciado')->nullable();
            $table->longText('justificacion')->nullable();
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
        Schema::dropIfExists('mp_agencia_informes');
    }
}
