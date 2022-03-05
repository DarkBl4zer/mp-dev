<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_Policivos extends Model
{
    protected $table = 'mp_policivos';
    protected $fillable = ['tipo_formulario','id_tipo_mp','sinproc','act_sinproc','habilitar_archivo','tipo_actuacion','clase_diligencia','despacho_judicial','estado_audiencia','numero','numero_cordis','clase','autoridad','fecha_actuacion','observaciones','archivo_dt','archivo_or','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
