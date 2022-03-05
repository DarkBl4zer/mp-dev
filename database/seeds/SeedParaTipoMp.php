<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Tipo_MP;
use Illuminate\Database\Seeder;

class SeedParaTipoMp extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'valor' => 1, 'nombre' => 'PENALES1'),
            array('usuario_crea' => 0, 'valor' => 2, 'nombre' => 'PENALES2'),
            array('usuario_crea' => 0, 'valor' => 3, 'nombre' => 'MOVILIDAD'),
            array('usuario_crea' => 0, 'valor' => 4, 'nombre' => 'JUZGADOS'),
            array('usuario_crea' => 0, 'valor' => 5, 'nombre' => 'SEGUNDA'),
            array('usuario_crea' => 0, 'valor' => 6, 'nombre' => 'PENALES1Y2'),
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Tipo_MP::create($datos[$i]);
        }
    }
}
