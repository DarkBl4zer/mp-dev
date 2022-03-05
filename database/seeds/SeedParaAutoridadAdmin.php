<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Autoridad_Admin;
use Illuminate\Database\Seeder;

class SeedParaAutoridadAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'valor' => 1, 'nombre' => 'LA SECRETARÍA DISTRITAL DE GOBIERNO.'),
            array('usuario_crea' => 0, 'valor' => 2, 'nombre' => 'LA SECRETARÍA DISTRITAL DE SEGURIDAD, CONVIVENCIA Y JUSTICIA'),
            array('usuario_crea' => 0, 'valor' => 3, 'nombre' => 'LA SECRETARÍA DISTRITAL DE SALUD.'),
            array('usuario_crea' => 0, 'valor' => 4, 'nombre' => 'LA SECRETARÍA DISTRITAL DE AMBIENTE.'),
            array('usuario_crea' => 0, 'valor' => 5, 'nombre' => 'LA SECRETARÍA DISTRITAL DE PLANEACIÓN.'),
            array('usuario_crea' => 0, 'valor' => 6, 'nombre' => 'LA SECRETARÍA DE EDUCACIÓN DEL DISTRITO.'),
            array('usuario_crea' => 0, 'valor' => 7, 'nombre' => 'EL DEPARTAMENTO ADMINISTRATIVO DE LA DEFENSORÍA DEL ESPACIO PÚBLICO.'),
            array('usuario_crea' => 0, 'valor' => 8, 'nombre' => 'LA UNIDAD ADMINISTRATIVA ESPECIAL CUERPO OFICIAL DE BOMBEROS DE BOGOTÁ D.C.'),
            array('usuario_crea' => 0, 'valor' => 9, 'nombre' => 'LAS COMISARÍAS DE FAMILIA.'),
            array('usuario_crea' => 0, 'valor' => 10, 'nombre' => 'EL INSTITUTO DISTRITAL DE PROTECCIÓN Y BIENESTAR ANIMAL.'),
            array('usuario_crea' => 0, 'valor' => 11, 'nombre' => 'LA SECRETARÍA DISTRITAL DEL HÁBITAT.'),
            array('usuario_crea' => 0, 'valor' => 12, 'nombre' => 'LA SECRETARÍA DISTRITAL DE CULTURA, RECREACIÓN Y DEPORTE.'),
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Autoridad_Admin::create($datos[$i]);
        }
    }
}
