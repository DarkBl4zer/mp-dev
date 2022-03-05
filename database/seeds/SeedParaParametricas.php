<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Parametricas;
use Illuminate\Database\Seeder;

class SeedParaParametricas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'valor' => 1, 'tabla' => 'mp_para_actuacion', 'nombre' => 'ACTUACIONES'),
            array('usuario_crea' => 0, 'valor' => 2, 'tabla' => 'mp_para_clase_diligencia', 'nombre' => 'CLASE DE DILIGENCIA'),
            array('usuario_crea' => 0, 'valor' => 3, 'tabla' => 'mp_para_estado_audiencia', 'nombre' => 'ESTADO DE AUDIENCIA'),
            array('usuario_crea' => 0, 'valor' => 4, 'tabla' => 'mp_para_clase_policivo', 'nombre' => 'CLASE POLICIVO'),
            array('usuario_crea' => 0, 'valor' => 5, 'tabla' => 'mp_para_criterio_creacion', 'nombre' => 'CRITERIO DE CREACIÓN'),
            array('usuario_crea' => 0, 'valor' => 6, 'tabla' => 'mp_para_criterio_intervencion', 'nombre' => 'CRITERIO DE INTERVENCIÓN'),
            array('usuario_crea' => 0, 'valor' => 7, 'tabla' => 'mp_para_delegada', 'nombre' => 'DELEGADA AGENCIA ESPECIAL'),
            array('usuario_crea' => 0, 'valor' => 8, 'tabla' => 'mp_para_delito', 'nombre' => 'DELITOS'),
            array('usuario_crea' => 0, 'valor' => 9, 'tabla' => 'mp_para_despacho', 'nombre' => 'DESPACHOS PENALES1/2'),
            array('usuario_crea' => 0, 'valor' => 10, 'tabla' => 'mp_para_autoridad_admin', 'nombre' => 'AUTORIDAD ADMINISTRATIVA'),
            array('usuario_crea' => 0, 'valor' => 11, 'tabla' => 'mp_para_tipo_victima', 'nombre' => 'TIPO DE VICTIMA'),
            array('usuario_crea' => 0, 'valor' => 12, 'tabla' => 'mp_para_unidad', 'nombre' => 'UNIDAD'),
            array('usuario_crea' => 0, 'valor' => 13, 'tabla' => 'mp_para_usuarios', 'nombre' => 'USUARIOS'),
            array('usuario_crea' => 0, 'valor' => 14, 'tabla' => 'mp_para_festivos', 'nombre' => 'DÍAS FESTIVOS'),
            array('usuario_crea' => 0, 'valor' => 15, 'tabla' => 'mp_para_despachoj', 'nombre' => 'DESPACHOS JUZGADOS'),
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Parametricas::create($datos[$i]);
        }
    }
}
