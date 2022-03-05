<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Criterio_Creacion;
use Illuminate\Database\Seeder;

class SeedParaCriterioCreacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'valor' => 1, 'nombre' => 'LA NATURALEZA DEL DELITO.'),
            array('usuario_crea' => 0, 'valor' => 2, 'nombre' => 'LAS CONDICIONES ESPECIALES DE LA ACTUACIÓN, CUANDO SE DEN CIRCUNSTANCIAS QUE PUEDAN AFECTAR LAS GARANTÍAS PROCESALES DEL IMPUTADO, LA IMPARCIALIDAD O INDEPENDENCIA DE LA ADMINISTRACIÓN DE JUSTICIA.'),
            array('usuario_crea' => 0, 'valor' => 3, 'nombre' => 'POR LA CALIDAD DEL SUJETO PASIVO, CUANDO SE TRATE DE PERSONAS DE ESPECIAL PROTECCIÓN CONSTITUCIONAL (MENOR DE EDAD, MUJER, ADULTO MAYOR, PERSONAS CON DISCAPACIDAD.'),
            array('usuario_crea' => 0, 'valor' => 4, 'nombre' => 'LA ALARMA SOCIAL, EN TODOS AQUELLOS CASOS EN LOS QUE, ATENDIDAS CIRCUNSTANCIAS OBJETIVAS, SE DETERMINE QUE EL HECHO PUNIBLE HA CAUSADO GRAN IMPACTO EN LA COLECTIVIDAD, CUALQUIERA QUE SEA LA NATURALEZA DE ÉSTE.'),
            array('usuario_crea' => 0, 'valor' => 5, 'nombre' => 'LA DISCRECIONALIDAD DEL PERSONERO(A)  DE BOGOTÁ D.C., CUANDO ASÍ LO DETERMINE, EN EJERCICIO DE SU PODER DISCRECIONAL Y DE ACUERDO CON LAS POLÍTICAS GENERALES DE INTERVENCIÓN EN DEFENSA DEL ORDEN JURÍDICO, DEL PATRIMONIO PÚBLICO, O DE LOS DERECHOS Y GARANTÍAS FUNDAMENTALES.'),
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Criterio_Creacion::create($datos[$i]);
        }
    }
}
