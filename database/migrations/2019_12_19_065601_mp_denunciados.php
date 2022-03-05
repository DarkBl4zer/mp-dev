<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MpDenunciados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_denunciados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_tipo_mp');
            $table->bigInteger('id_actuacion');
            $table->integer('cantidad')->nullable();
            $table->bigInteger('sexo')->nullable();
            $table->bigInteger('identidad')->nullable();
            $table->bigInteger('orientacion')->nullable();
            $table->bigInteger('nacionalidad')->nullable();
            $table->string('primer_nombre', 255)->nullable();
            $table->string('segundo_nombre', 255)->nullable();
            $table->string('primer_apellido', 255)->nullable();
            $table->string('segundo_apellido', 255)->nullable();
            $table->string('tipo_documento', 255)->nullable();
            $table->string('numero_documento', 255)->nullable();
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
        Schema::dropIfExists('mp_denunciados');
    }
}
