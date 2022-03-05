<?php
date_default_timezone_get('America/Bogota');

use App\Models\Para_Delegada;
use Illuminate\Database\Seeder;

class SeedParaDelegada extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0 ,'valor' => 1, 'nombre'=> 'PENALES 1'),
            array('usuario_crea' => 0 ,'valor' => 2, 'nombre'=> 'PENALES 2'),

        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Delegada::create($datos[$i]);
        }
    }
}
