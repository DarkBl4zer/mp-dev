<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MpAgencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_agencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero_agencia_especial');
            $table->date('fecha_creacion');
            $table->integer('delegada');
            $table->integer('nombre_ministerio');
            $table->string('noticia_criminal');
            $table->string('despacho_judicial');
            $table->string('nombre_unidad');
            $table->string('adecuacion_tipica');
            $table->integer('criterio_creacion');
            $table->longText('justificacion');
            $table->longText('sintesis')->nullable();
            $table->integer('estado')->default(1);
            $table->longText('justificacion_fin')->nullable();
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
        Schema::dropIfExists('mp_agencia');
    }
}
