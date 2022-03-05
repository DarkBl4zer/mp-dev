<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MpParaUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_para_usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('valor');
            $table->string('nombre', 255);
            $table->integer('id_rol');
            $table->string('email', 255)->nullable();
            $table->integer('idD')->nullable();
            $table->string('nombreD', 255)->nullable();
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
        Schema::dropIfExists('mp_para_usuarios');
    }
}
