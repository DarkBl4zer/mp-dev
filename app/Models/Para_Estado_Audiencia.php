<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Estado_Audiencia extends Model
{
    protected $table = 'mp_para_estado_audiencia';
    protected $fillable = ['id_tipo_mp','valor','nombre','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
