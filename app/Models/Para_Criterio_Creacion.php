<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Criterio_Creacion extends Model
{
    protected $table = 'mp_para_criterio_creacion';
    protected $fillable = ['valor','nombre','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
