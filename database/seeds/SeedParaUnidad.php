<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Unidad;
use Illuminate\Database\Seeder;

class SeedParaUnidad extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'id_tipo_mp' => 1, 'valor' => 1, 'nombre' => 'Cuenta CENTRO DE ATENCIÓN PENAL INTEGRAL A VICTIMAS CAPIV'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 1, 'valor' => 2, 'nombre' => 'Cuenta GRUPO DE CASOS QUERELLABLES'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 1, 'valor' => 3, 'nombre' => 'Cuenta GRUPO DE INVESTIGACIÓN Y JUDICIALIZACIÓN'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 1, 'valor' => 4, 'nombre' => 'Cuenta JUZGADOS DE GARANTIAS'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 1, 'valor' => 5, 'nombre' => 'Cuenta JUZGADOS PENALES MUNICIPALES CON FUNCION DE CONOCIMIENTO'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 1, 'valor' => 6, 'nombre' => 'Cuenta UNIDAD DE DELITOS CONTRA LA VIOLENCIA INTRAFAMILIAR'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 1, 'valor' => 7, 'nombre' => 'Cuenta UNIDAD DE HURTOS'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 8, 'nombre' => 'CENTRO DE ATENCIÓN PENAL INTEGRAL A VICTIMAS CAPIV'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 9, 'nombre' => 'DIRECCIÓN ESPECIALIZADA CONTRA EL CRIMEN ORGANIZADO DECOC'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 10, 'nombre' => 'GRUPO DE INVESTIGACIÓN Y JUDICIALIZACIÓN'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 11, 'nombre' => 'INVESTIGACIÓN Y JUDICIALIZACIÓN'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 12, 'nombre' => 'LEY 600 DE 2000'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 13, 'nombre' => 'UNIDAD CONTRA LA VIDA E INTEGRIDAD PERSONAL'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 14, 'nombre' => 'UNIDAD DE DELITOS CONTRA LA ADMINISTRACIÓN PÚBLICA, CONTRA LA EFICAS Y RECTA IMPARTICIÓN DE JUSTICIA Y CONTRA LOS MECANISMOS DE PARTICIPACIÓN DEMOCRATICA'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 15, 'nombre' => 'UNIDAD DE DELITOS CONTRA LA LIBERTAD, INTEGRIDAD Y FORMACIÓN SEXUALES'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 16, 'nombre' => 'UNIDAD DE DELITOS CONTRA LA SEGURIDAD PÚBLICA, SALUD PÚBLICA, LIBERTAD INDIVIDUAL Y OTROS'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 17, 'nombre' => 'UNIDAD DE ESTAFAS'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 18, 'nombre' => 'UNIDAD DE ESTRUCTURA DE APOYO'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 19, 'nombre' => 'UNIDAD DE GESTIÓN DE ALERTAS Y CLASIFICACIÓN TEMPRANA DE DENUNCIAS'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 20, 'nombre' => 'UNIDAD DE HURTO '),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 21, 'nombre' => 'UNIDAD DE HURTOS'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 22, 'nombre' => 'UNIDAD DE LIBERTAD PERSONAL'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 2, 'valor' => 23, 'nombre' => 'UNIDAD DE REACCIÓN INMEDIATA'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 3, 'valor' => 24, 'nombre' => 'SECRETARÍA DE MOVILIDAD'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 4, 'valor' => 25, 'nombre' => 'CIVIL MUNICIPAL DE DESCONGESTIÓN - COMPETENCIA MULTIPLE DE CIUDAD BOLÍVAR'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 4, 'valor' => 26, 'nombre' => 'CIVIL MUNICIPAL DE DESCONGESTIÓN - COMPETENCIA MULTIPLE DE KENNEDY'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 4, 'valor' => 27, 'nombre' => 'CIVIL MUNICIPAL DE DESCONGESTIÓN - COMPETENCIA MULTIPLE'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 4, 'valor' => 28, 'nombre' => 'CIVIL MUNICIPAL'),
            array('usuario_crea' => 0, 'id_tipo_mp' => 4, 'valor' => 29, 'nombre' => 'PEQUEÑAS CAUSAS'),            
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Unidad::create($datos[$i]);
        }
    }
}
