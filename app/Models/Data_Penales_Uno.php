<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_Penales_Uno extends Model
{
    protected $table = 'mp_penales_uno';
    protected $fillable = ['tipo_formulario','agencia_especial','sinproc','act_sinproc','habilitar_archivo','identifica_denunciado','tipo_actuacion','clase_diligencia','estado_audiencia','criterio_intervencion','despacho_judicial','noticia_criminal','delito','numero_cordis','fecha_actuacion','observaciones','archivo_dt','archivo_or','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
