<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Estado_Audiencia;
use Illuminate\Database\Seeder;

class SeedParaEstadoAudiencia extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            //========================== Estado de Audiencia Penales1 y Penales2 ==========================
                array('usuario_crea' => 0, 'valor' => 1, 'id_tipo_mp' => 6, 'nombre' => 'REALIZADA'),
                array('usuario_crea' => 0, 'valor' => 2, 'id_tipo_mp' => 6, 'nombre' => 'APLAZADA'),
                array('usuario_crea' => 0, 'valor' => 3, 'id_tipo_mp' => 6, 'nombre' => 'SUSPENDIDA'),
            //========================== Estado de Audiencia Movilidad ==========================
                array('usuario_crea' => 0, 'valor' => 4, 'id_tipo_mp' => 3, 'nombre' => 'REALIZADA'),
                array('usuario_crea' => 0, 'valor' => 5, 'id_tipo_mp' => 3, 'nombre' => 'SUSPENDIDA'),
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Estado_Audiencia::create($datos[$i]);
        }
    }
}
