<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_DespachoJ extends Model
{
    protected $table = 'mp_para_despachoj';
    protected $fillable = ['valor','nombre','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
