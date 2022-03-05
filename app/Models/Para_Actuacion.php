<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Actuacion extends Model
{
    protected $table = 'mp_para_actuacion';
    protected $fillable = ['id_tipo_mp','valor','nombre','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
