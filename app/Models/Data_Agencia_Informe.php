<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data_Agencia_Informe extends Model
{
    protected $table = 'mp_agencia_informes';
    protected $fillable = ['id_agencia_especial','numero_agencia_especial','fecha_informe','id_periodo_reportado','periodo_reportado','tipo_victima','actuacion_procesal','datos_victima','corregir_delito','dato_indiciado','fin_ae','nuevo_delito','nuevo_despacho','nombre_indiciado','indentificacion_indiciado','justificacion','eliminado','usuario_crea','usuario_modifica'];
    protected $guarded = ['id'];
}
