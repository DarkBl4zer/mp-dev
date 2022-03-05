<?php
date_default_timezone_set('America/Bogota');

use App\Models\Para_Usuarios;
use Illuminate\Database\Seeder;

class SeedParaUsuarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            array('usuario_crea' => 0, 'valor' => 52214657, 'id_rol' => 1, 'nombre' => 'MONICA TERESA MEJIA ARENAS'),
            array('usuario_crea' => 0, 'valor' => 19269050, 'id_rol' => 1, 'nombre' => 'NESTOR JULIO GOMEZ SAMUDIO'),
            array('usuario_crea' => 0, 'valor' => 3081088, 'id_rol' => 1, 'nombre' => 'SABINO PULGARIN ARIAS'),
            array('usuario_crea' => 0, 'valor' => 39692331, 'id_rol' => 1, 'nombre' => 'GLORIA LILIANA HERRERA CASAS'),
            array('usuario_crea' => 0, 'valor' => 19429026, 'id_rol' => 1, 'nombre' => 'JOSE GUSTAVO BARON BERNA'),
            array('usuario_crea' => 0, 'valor' => 41723420, 'id_rol' => 1, 'nombre' => 'MIREYA MARIA CUELLAR SIERRA'),
            array('usuario_crea' => 0, 'valor' => 79103406, 'id_rol' => 1, 'nombre' => 'JORGE HENRY MORENO CAJICÁ'),
            array('usuario_crea' => 0, 'valor' => 79350304, 'id_rol' => 1, 'nombre' => 'JESUS ORLANDO ROMERO'),
            array('usuario_crea' => 0, 'valor' => 18388180, 'id_rol' => 1, 'nombre' => 'EDGAR SIERRA GUERRERO'),
            array('usuario_crea' => 0, 'valor' => 51922254, 'id_rol' => 1, 'nombre' => 'MARIA CLARIBEL CABRERA PUENTES'),
            array('usuario_crea' => 0, 'valor' => 16253230, 'id_rol' => 1, 'nombre' => 'JOSE DOVER DAZA PINEDA'),
            array('usuario_crea' => 0, 'valor' => 51724379, 'id_rol' => 1, 'nombre' => 'VILMA PIEDAD DELGADO PEÑA'),
            array('usuario_crea' => 0, 'valor' => 65691398, 'id_rol' => 1, 'nombre' => 'NANCY ORTIZ CAVIEDEZ'),
            array('usuario_crea' => 0, 'valor' => 51867408, 'id_rol' => 1, 'nombre' => 'SANDRA JEANNETTE VASQUES ARIZA'),
            array('usuario_crea' => 0, 'valor' => 17318897, 'id_rol' => 1, 'nombre' => 'HELMAN ANTONIO CESPEDES ROMERO'),
            array('usuario_crea' => 0, 'valor' => 52328476, 'id_rol' => 1, 'nombre' => 'DIANA ALEXANDRA GONZALEZ VARGAS'),
            array('usuario_crea' => 0, 'valor' => 19282394, 'id_rol' => 1, 'nombre' => 'LUIS EDUARDO SUAREZ CANO'),
            array('usuario_crea' => 0, 'valor' => 80018919, 'id_rol' => 1, 'nombre' => 'OSCAR JAVIER HERNANDEZ TELLEZ'),
            array('usuario_crea' => 0, 'valor' => 12105229, 'id_rol' => 1, 'nombre' => 'ARGEMIRO VARGAS MORENO'),
            array('usuario_crea' => 0, 'valor' => 79984498, 'id_rol' => 1, 'nombre' => 'JUAN CARLOS CASTAÑEDA HERNANDEZ'),
            array('usuario_crea' => 0, 'valor' => 2954845, 'id_rol' => 1, 'nombre' => 'JORGE HERNANDO MOLINA MONROY'),
            array('usuario_crea' => 0, 'valor' => 39700362, 'id_rol' => 1, 'nombre' => 'MARITZA SALAZAR DUARTE'),
            array('usuario_crea' => 0, 'valor' => 30731477, 'id_rol' => 2, 'nombre' => 'CAICEDO CALDERON MONICA LILIANA'),
            array('usuario_crea' => 0, 'valor' => 19472165, 'id_rol' => 2, 'nombre' => 'ALVAREZ GUERRERO EDILBERTO'),
            array('usuario_crea' => 0, 'valor' => 79272272, 'id_rol' => 2, 'nombre' => 'BARROSO PARDO FRANCISCO JOSE'),
            array('usuario_crea' => 0, 'valor' => 51816465, 'id_rol' => 2, 'nombre' => 'BUITRAGO DÍAZ CRISTINA DEL PILAR'),
            array('usuario_crea' => 0, 'valor' => 11336918, 'id_rol' => 2, 'nombre' => 'CANCINO FORERO EDGAR MAURICIO'),
            array('usuario_crea' => 0, 'valor' => 7303433, 'id_rol' => 2, 'nombre' => 'CAÑON INFANTE JORGE ELIÉCER'),
            array('usuario_crea' => 0, 'valor' => 51631293, 'id_rol' => 2, 'nombre' => 'CARRASCAL BERMÚDEZ MAGALY STELLA'),
            array('usuario_crea' => 0, 'valor' => 79453720, 'id_rol' => 2, 'nombre' => 'CARREÑO GARZÓN OMAR HERNANDO'),
            array('usuario_crea' => 0, 'valor' => 19264805, 'id_rol' => 2, 'nombre' => 'CASTILLO ALVIS LUIS EDUARDO'),
            array('usuario_crea' => 0, 'valor' => 79101592, 'id_rol' => 2, 'nombre' => 'CONTRERAS ROBERTO ABUNDIO'),
            array('usuario_crea' => 0, 'valor' => 51674442, 'id_rol' => 2, 'nombre' => 'CORTES BALLEN MARIA TERESA'),
            array('usuario_crea' => 0, 'valor' => 12722956, 'id_rol' => 2, 'nombre' => 'ALDANA VARGAS JOSE GABRIEL'),
            array('usuario_crea' => 0, 'valor' => 51784286, 'id_rol' => 2, 'nombre' => 'DOMÍNGUEZ LONDOÑO LEDA'),
            array('usuario_crea' => 0, 'valor' => 79488467, 'id_rol' => 2, 'nombre' => 'GAITÁN MONTAÑEZ CARLOS EDUARDO'),
            array('usuario_crea' => 0, 'valor' => 19326899, 'id_rol' => 2, 'nombre' => 'GOMEZ HERNÁNDEZ LUIS EDUARDO'),
            array('usuario_crea' => 0, 'valor' => 403848, 'id_rol' => 2, 'nombre' => 'GOMEZ TOVAR LUIS ALFREDO'),
            array('usuario_crea' => 0, 'valor' => 80408458, 'id_rol' => 2, 'nombre' => 'GONZÁLEZ ALARCÓN JOSÉ DE JESÚS'),
            array('usuario_crea' => 0, 'valor' => 23809424, 'id_rol' => 5, 'nombre' => 'GUAUQUE DÍAZ ANA EMILCE'),
            array('usuario_crea' => 0, 'valor' => 17330042, 'id_rol' => 4, 'nombre' => 'HERNÁNDEZ MELO ALBERTO'),
            array('usuario_crea' => 0, 'valor' => 51613886, 'id_rol' => 2, 'nombre' => 'MORENO BARBOSA MARÍA NANCY'),
            array('usuario_crea' => 0, 'valor' => 79351853, 'id_rol' => 2, 'nombre' => 'OSPINA CARLOS ALBERTO'),
            array('usuario_crea' => 0, 'valor' => 19265517, 'id_rol' => 2, 'nombre' => 'PATIÑO DÍAZ ANTONIO'),
            array('usuario_crea' => 0, 'valor' => 51870539, 'id_rol' => 2, 'nombre' => 'RODRÍGUEZ JIMÉNEZ CARMEN DEISY'),
            array('usuario_crea' => 0, 'valor' => 51646939, 'id_rol' => 2, 'nombre' => 'SILGADO BETANCOURT DIANA EMPERATRIZ'),
            array('usuario_crea' => 0, 'valor' => 1015393662, 'id_rol' => 2, 'nombre' => 'TORRES SANCHEZ WILLIAM LEONARDO'),
            array('usuario_crea' => 0, 'valor' => 19435495, 'id_rol' => 2, 'nombre' => 'VANEGAS FLOREZ OMAR'),
            array('usuario_crea' => 0, 'valor' => 17321867, 'id_rol' => 2, 'nombre' => 'VILLARREAL RODRIGUEZ PEDRO ROYEL'),
            array('usuario_crea' => 0, 'valor' => 51624233, 'id_rol' => 3, 'nombre' => 'LUZ STELLA MOLINA HERNANDEZ'),
            array('usuario_crea' => 0, 'valor' => 63307045, 'id_rol' => 3, 'nombre' => 'MARIA DEL PILAR CASTELLANOS ARDILA'),
            array('usuario_crea' => 0, 'valor' => 14240896, 'id_rol' => 3, 'nombre' => 'CARLOS ARTURO LEYTON YARA'),
            array('usuario_crea' => 0, 'valor' => 93345707, 'id_rol' => 3, 'nombre' => 'ARISTOBULO MENDOZA DIAZ'),
            array('usuario_crea' => 0, 'valor' => 79393267, 'id_rol' => 3, 'nombre' => 'LUIS ARTURO CEPEDA SANCHEZ'),
            array('usuario_crea' => 0, 'valor' => 11409730, 'id_rol' => 3, 'nombre' => 'HECTOR ROMAN MORALES BETANCOURT'),
            array('usuario_crea' => 0, 'valor' => 13742478, 'id_rol' => 3, 'nombre' => 'EDGAR MAURICIO SANTOS SANTOS'),
            array('usuario_crea' => 0, 'valor' => 51621314, 'id_rol' => 5, 'nombre' => 'SONIA CONSUELO DEVIA VALDERRAMA'),
            //===================== De ejemplo ============================
            array('usuario_crea' => 0, 'valor' => 1000, 'id_rol' => 4, 'nombre' => 'Ministerio público (Policivos - Juzgados)'),
            array('usuario_crea' => 0, 'valor' => 1001, 'id_rol' => 5, 'nombre' => 'Ministerio público (Policivos - Segunda)'),
            array('usuario_crea' => 0, 'valor' => 1002, 'id_rol' => 6, 'nombre' => 'Delegado(a) Penales 1'),
            array('usuario_crea' => 0, 'valor' => 1003, 'id_rol' => 7, 'nombre' => 'Delegado(a) Penales 2'),
            array('usuario_crea' => 0, 'valor' => 1004, 'id_rol' => 8, 'nombre' => 'Delegado(a) Policivos'),
            array('usuario_crea' => 0, 'valor' => 1005, 'id_rol' => 9, 'nombre' => 'Coordinador(a)'),
            array('usuario_crea' => 0, 'valor' => 1010, 'id_rol' => 10, 'email' => 'admin@admin.com', 'idD' => 10, 'nombreD' => 'TIC', 'nombre' => 'Administrador(a)'),
        ];
        for ($i=0; $i < count($datos); $i++) { 
            Para_Usuarios::create($datos[$i]);
        }
    }
}
