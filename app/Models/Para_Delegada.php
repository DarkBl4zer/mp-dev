<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Delegada extends Model
{
    protected $table = 'mp_para_delegada';
    protected $fillable = ['valor', 'nombre', 'eliminado', 'usuario_crea', 'usuario_modifica'];
    protected $guarded = ['id'];
}
