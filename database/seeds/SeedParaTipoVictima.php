<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Tipo_Victima;
use Illuminate\Database\Seeder;

class SeedParaTipoVictima extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'valor' => 1, 'nombre' => 'NIÑOS (AS) MENORES DE 14 AÑOS'),
            array('usuario_crea' => 0, 'valor' => 2, 'nombre' => 'NIÑAS (OS) MENORES DE 18 AÑOS'),
            array('usuario_crea' => 0, 'valor' => 3, 'nombre' => 'MUJER'),
            array('usuario_crea' => 0, 'valor' => 4, 'nombre' => 'ADULTO MAYOR'),
            array('usuario_crea' => 0, 'valor' => 5, 'nombre' => 'PERSONA CON DISCAPACIDAD'),
            array('usuario_crea' => 0, 'valor' => 6, 'nombre' => 'HOMBRE'),
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Tipo_Victima::create($datos[$i]);
        }
    }
}
