<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_Denunciados extends Model
{
    protected $table = 'mp_denunciados';
    protected $fillable = ['id_tipo_mp','id_actuacion','cantidad','sexo','identidad','orientacion','nacionalidad','primer_nombre','segundo_nombre','primer_apellido','segundo_apellido','tipo_documento','numero_documento','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
