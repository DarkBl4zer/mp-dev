<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Criterio_Intervencion;
use Illuminate\Database\Seeder;

class SeedParaCriterioIntervencion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'valor' => 1, 'nombre' => 'IMPUNIDAD'),
            array('usuario_crea' => 0, 'valor' => 2, 'nombre' => 'CUANDO LA VICTIMA SEA MENOR DE EDAD'),
            array('usuario_crea' => 0, 'valor' => 3, 'nombre' => 'CUANDO POR RAZÓN DE SU GÉNERO LA MUJER ES VICTIMA'),
            array('usuario_crea' => 0, 'valor' => 4, 'nombre' => 'CUANDO EL PROCESADO ES INVESTIGADO EN AUSENCIA'),
            array('usuario_crea' => 0, 'valor' => 5, 'nombre' => 'CUANDO EL PROCESADO ESTA PRIVADO DE SU LIBERTAD'),
            array('usuario_crea' => 0, 'valor' => 6, 'nombre' => 'CUANDO NO HAY PARTE CIVIL Y/O REPRESENTANTE DE VÍCTIMA'),
            array('usuario_crea' => 0, 'valor' => 7, 'nombre' => 'EN LOS PROCESOS DE SIGNIFICATIVA Y RELEVANTE IMPORTANCIA (ALARMA SOCIAL)'),
            array('usuario_crea' => 0, 'valor' => 8, 'nombre' => 'CUANDO SE HA CONSTITUIDO VIGILANCIA O AGENCIA ESPECIAL'),
            array('usuario_crea' => 0, 'valor' => 9, 'nombre' => 'CUANDO SE ADVIERTA VULNERACIÓN DE DERECHOS Y GARANTIAS FUNDAMENTALES.'),
            array('usuario_crea' => 0, 'valor' => 10, 'nombre' => 'EN LAS ACTUACIONES QUE SE PONGA FIN AL PROCESO (PRINCIPIO DE OPORTUNIDAD)'),
            array('usuario_crea' => 0, 'valor' => 11, 'nombre' => 'INTERES DE LOS ORGANISMOS INTERNACIONALES DE DERECHOS HUMANOS '),
            array('usuario_crea' => 0, 'valor' => 12, 'nombre' => 'INTERES DE LOS MÁXIMOS TRIBUNALES DE JUSTICIA COLOMBIANOS'),
            array('usuario_crea' => 0, 'valor' => 13, 'nombre' => 'EN LOS DELITOS CONTRA LA VIDA E INTEGRIDAD PERSONAL CUANDO SE COMETE EN PERSONAS CUALIFICADAS'),
            array('usuario_crea' => 0, 'valor' => 14, 'nombre' => 'EN DELITOS DE HOMICIDIO, LESIONES PERSONALES, CONTRA LA LIBERTAD, INTEGRIDAD Y FORMACION SEXUALES O SECUESTRO COMETIDOS CONTRA NIÑOS, NIÑAS Y ADOLECENTES.'),
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Criterio_Intervencion::create($datos[$i]);
        }
    }
}
