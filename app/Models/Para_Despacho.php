<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Para_Despacho extends Model
{
    protected $table = 'mp_para_despacho';
    protected $fillable = ['id_tipo_mp', 'valor', 'nombre', 'codigo', 'eliminado', 'usuario_crea', 'usuario_modifica'];
    protected $guarded = ['id'];
}
