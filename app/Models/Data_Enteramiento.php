<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_Enteramiento extends Model
{
    protected $table = 'mp_enteramiento';
    protected $fillable = ['id_tipo_mp','cantidad','unidad', 'archivo_dt', 'archivo_or', 'eliminado', 'usuario_crea', 'usuario_modifica'];
    protected $guarded = ['id'];
}
