<?php

use App\Models\Para_Festivos;
use Illuminate\Database\Seeder;

class SeedParaFestivos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'valor' => '2019-12-08', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2019-12-25', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-01-01', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-01-06', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-03-23', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-04-09', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-04-10', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-05-01', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-05-25', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-06-15', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-06-22', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-06-29', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-07-20', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-08-07', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-08-17', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-10-12', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-11-02', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-11-16', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-12-08', 'nombre' => 'Festivo'),
            array('usuario_crea' => 0, 'valor' => '2020-12-25', 'nombre' => 'Festivo')
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Festivos::create($datos[$i]);
        }
    }
}
