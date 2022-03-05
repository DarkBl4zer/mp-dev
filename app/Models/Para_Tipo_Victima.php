<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Tipo_Victima extends Model
{
    protected $table = 'mp_para_tipo_victima';
    protected $fillable = ['valor', 'nombre', 'eliminado', 'usuario_crea', 'usuario_modifica'];
    protected $guarded = ['id'];
}
