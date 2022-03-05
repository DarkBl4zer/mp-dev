<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Roles;
use Illuminate\Database\Seeder;

class SeedParaRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'valor' => 1, 'nombre' => 'Ministerio público (Penales 1)'),
            array('usuario_crea' => 0, 'valor' => 2, 'nombre' => 'Ministerio público (Penales 2)'),
            array('usuario_crea' => 0, 'valor' => 3, 'nombre' => 'Ministerio público (Policivos - Movilidad)'),
            array('usuario_crea' => 0, 'valor' => 4, 'nombre' => 'Ministerio público (Policivos - Juzgados)'),
            array('usuario_crea' => 0, 'valor' => 5, 'nombre' => 'Ministerio público (Policivos - Segunda)'),
            array('usuario_crea' => 0, 'valor' => 6, 'nombre' => 'Delegado(a) Penales 1'),
            array('usuario_crea' => 0, 'valor' => 7, 'nombre' => 'Delegado(a) Penales 2'),
            array('usuario_crea' => 0, 'valor' => 8, 'nombre' => 'Delegado(a) Policivos'),
            array('usuario_crea' => 0, 'valor' => 9, 'nombre' => 'Coordinador'),
            array('usuario_crea' => 0, 'valor' => 10, 'nombre' => 'Administrador')
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Roles::create($datos[$i]);
        }
    }
}
