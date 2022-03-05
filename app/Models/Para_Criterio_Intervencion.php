<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Criterio_Intervencion extends Model
{
    protected $table = 'mp_para_criterio_intervencion';
    protected $fillable = ['valor','nombre','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
