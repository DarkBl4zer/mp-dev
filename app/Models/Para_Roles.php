<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Roles extends Model
{
    protected $table = 'mp_para_roles';
    protected $fillable = ['valor','nombre','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
