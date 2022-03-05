<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Delito extends Model
{
    protected $table = 'mp_para_delito';
    protected $fillable = ['valor', 'nombre', 'codigo', 'eliminado', 'usuario_crea', 'usuario_modifica'];
    protected $guarded = ['id'];
}
