<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Clase_Diligencia extends Model
{
    protected $table = 'mp_para_clase_diligencia';
    protected $fillable = ['id_tipo_mp','id_actuacion','valor','nombre','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
