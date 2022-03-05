<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Autoridad_Admin extends Model
{
    protected $table = 'mp_para_autoridad_admin';
    protected $fillable = ['valor', 'nombre', 'eliminado', 'usuario_crea', 'usuario_modifica'];
    protected $guarded = ['id'];
}
