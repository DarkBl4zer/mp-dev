<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Actuacion;
use Illuminate\Database\Seeder;

class SeedParaActuacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            //========================== Actuaciones Penales1 ==========================
            array('usuario_crea' => 0, 'valor' => 1, 'id_tipo_mp' => 1, 'nombre' => '0_INTERVENCIÓN EN AUDIENCIAS LEY 906'),
            array('usuario_crea' => 0, 'valor' => 2, 'id_tipo_mp' => 6, 'nombre' => '0_RECURSOS LEY 906'),
            array('usuario_crea' => 0, 'valor' => 3, 'id_tipo_mp' => 6, 'nombre' => '0_SOLICITUDES LEY 906'),
            array('usuario_crea' => 0, 'valor' => 4, 'id_tipo_mp' => 1, 'nombre' => '0_OTRAS SOLICITUDES LEY 906'),
            array('usuario_crea' => 0, 'valor' => 5, 'id_tipo_mp' => 1, 'nombre' => '0_INTERVENCIONES Y ACTUACIONES LEY 906'),
            array('usuario_crea' => 0, 'valor' => 6, 'id_tipo_mp' => 1, 'nombre' => 'INTERVENCIÓN EN AUDIENCIAS LEY 1826'),
            array('usuario_crea' => 0, 'valor' => 7, 'id_tipo_mp' => 1, 'nombre' => 'RECURSOS LEY 1826'),
            array('usuario_crea' => 0, 'valor' => 8, 'id_tipo_mp' => 1, 'nombre' => 'CONCEPTOS LEY 600'),
            array('usuario_crea' => 0, 'valor' => 9, 'id_tipo_mp' => 6, 'nombre' => 'AUDIENCIAS LEY 600'),
            array('usuario_crea' => 0, 'valor' => 10, 'id_tipo_mp' => 6, 'nombre' => 'RECURSOS LEY 600'),
            array('usuario_crea' => 0, 'valor' => 11, 'id_tipo_mp' => 1, 'nombre' => 'ASISTENCIAS LEY 600'),
            array('usuario_crea' => 0, 'valor' => 12, 'id_tipo_mp' => 6, 'nombre' => 'SOLICITUDES LEY 600'),
            //========================== Actuaciones Penales2 ==========================
            array('usuario_crea' => 0, 'valor' => 13, 'id_tipo_mp' => 2, 'nombre' => '0_AUDIENCIAS LEY 906'),
            array('usuario_crea' => 0, 'valor' => 14, 'id_tipo_mp' => 2, 'nombre' => 'ACTUACIONES ADMINISTRATIVAS'),
            array('usuario_crea' => 0, 'valor' => 15, 'id_tipo_mp' => 2, 'nombre' => '0_DILIGENCIAS LEY 906'),
            array('usuario_crea' => 0, 'valor' => 16, 'id_tipo_mp' => 2, 'nombre' => 'DILIGENCIAS LEY 600'),
            array('usuario_crea' => 0, 'valor' => 17, 'id_tipo_mp' => 2, 'nombre' => 'ACTUACIONES LEY 600'),
            //========================== Actuaciones Movilidad ==========================
            array('usuario_crea' => 0, 'valor' => 18, 'id_tipo_mp' => 3, 'nombre' => 'AUDIENCIA'),
            array('usuario_crea' => 0, 'valor' => 19, 'id_tipo_mp' => 3, 'nombre' => 'INTERVENCIÓN'),
            //========================== Actuaciones Juzgados ==========================
            array('usuario_crea' => 0, 'valor' => 20, 'id_tipo_mp' => 4, 'nombre' => 'REVISIÓN DE PROCESO'),
            array('usuario_crea' => 0, 'valor' => 21, 'id_tipo_mp' => 4, 'nombre' => 'ACOMPAÑAMIENTO DILIGENCIA DE DESALOJO O ENTREGA DE INMUEBLE'),
            //========================== Actuaciones Segunda ==========================
            array('usuario_crea' => 0, 'valor' => 22, 'id_tipo_mp' => 5, 'nombre' => 'REVISIÓN DE QUERELLA'),
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Actuacion::create($datos[$i]);
        }
    }
}
