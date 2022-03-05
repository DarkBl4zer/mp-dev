<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Usuarios extends Model
{
    protected $table = 'mp_para_usuarios';
    protected $fillable = ['valor','nombre','id_rol','email','idD','nombreD','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
