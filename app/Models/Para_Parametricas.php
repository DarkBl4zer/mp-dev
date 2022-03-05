<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Parametricas extends Model
{
    protected $table = 'mp_para_parametricas';
    protected $fillable = ['valor','tabla','nombre','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
