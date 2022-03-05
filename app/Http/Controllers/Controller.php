<?php

namespace App\Http\Controllers;

use App\Models\Data_Notificaciones;
use App\Models\Para_Festivos;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function WSSinproc(){
        return 'http://dev.personeriabogota.gov.co/sinproc_P1/config/00_wssinproc/';
    }

    public function GenerarSelect($datos, $pre=false, $sel='xxx'){
        $select = '<option value="">-Seleccione Dato-</option>';
        foreach ($datos as $item) {
            $nombre = (substr($item->nombre, 0, 2) == '0_') ? str_replace("0_", "", $item->nombre) : $item->nombre;
            $selected = ($item->valor == $sel) ? 'selected' : 'false';
            if ($pre) {
                $select .= '<option value="' . $item->valor . '" ' . $selected . '>' . $item->codigo . ' -- ' . $nombre . '</option>';
            } else{
                $select .= '<option value="' . $item->valor . '" ' . $selected . '>' . $nombre . '</option>';
            }
        }
        return $select;
    }

    //<<Descripción>> Método que permite generar una pantalla de error para el usuario con un mensaje especifico.
    //<<Parámetro>> $msj (String) <<Descripción>> Texto que se mostrara en la pantalla de error.
    public function MostrarError($msj){
        $error = array('archivo' => 'x', 'mensaje' => $msj);
        return view('errores', compact('error'));
    }

    //<<Descripción>> Método que permite generar una pantalla de error no controlado con el detalle del error archivo y línea.
    //<<Parámetro>> $ex (PHPException) <<Descripción>> Objeto con las variables de la excepción presentada.
    public function MostrarErrorNoControl($ex){
        $temp = explode("\\", $ex->getFile());
        $archivo =  end($temp);
        $error = array('archivo' => $archivo, 'linea' => $ex->getLine(), 'mensaje' => $ex->getMessage());
        return view('errores', compact('error'));
    }

    public function Festivos(){
        $temp = Para_Festivos::get();
        $festivos = array();
        for ($i=0; $i < count($temp); $i++) { 
            $temp2 = explode(' ', $temp[$i]->valor);
            array_push($festivos, $temp2[0]);
        }
        return "var festivos = ['".implode("','",$festivos)."'];";
    }

    //==================================================== WebService SINPROC ====================================================
    
    public function ComboSexo($data=false){
        $json = file_get_contents(config('WSSinproc') . 'getSexo.php');
        $obj = json_decode($json);
        $retorno = $this->GenerarSelect($obj);
        if ($data) {
            return $obj;
        } else{
            return $retorno;
        }
    }

    public function ComboIdentidad($data=false){
        $json = file_get_contents(config('WSSinproc') . 'getIdentidad.php');
        $obj = json_decode($json);
        $retorno = $this->GenerarSelect($obj);
        if ($data) {
            return $obj;
        } else{
            return $retorno;
        }
    }

    public function ComboOrientacion($data=false){
        $json = file_get_contents(config('WSSinproc') . 'getOrientacion.php');
        $obj = json_decode($json);
        $retorno = $this->GenerarSelect($obj);
        if ($data) {
            return $obj;
        } else{
            return $retorno;
        }
    }

    public function ComboPaises($data=false){
        $json = file_get_contents(config('WSSinproc') . 'getPaises.php');
        $obj = json_decode($json);
        $retorno = $this->GenerarSelect($obj);
        if ($data) {
            return $obj;
        } else{
            return $retorno;
        }
    }

    public function Sinprocs($cedula){
        $json = file_get_contents(config('WSSinproc') . 'getPendientes.php?idFunc='.$cedula);
        $retorno = json_decode($json);
        return $retorno;
    }

    public function DetalleSinproc($sp, $decode=false){
        $json = file_get_contents(config('WSSinproc') . 'getDetallePendiente.php?id_transac='.$sp[0].'&idTramite='.$sp[1].'&annoCreacionSinproc='.$sp[2]);
        $retorno = json_decode($json);
        if ($decode) {
            return $retorno;
        } else {
            return $json;
        }
    }

    public function ComboTipoActuacion($idT){
        $json = file_get_contents(config('WSSinproc') . 'getTipoActuacion.php?idTramite='.$idT);
        $obj = json_decode($json);
        $retorno = $this->GenerarSelect($obj);
        return $retorno;
    }

    public function ComboDependencias($idT){
        $json = file_get_contents(config('WSSinproc') . 'getDependencias.php?idTramite='.$idT);
        $obj = json_decode($json);
        $retorno = $this->GenerarSelect($obj);
        return $retorno;
    }

    public function ComboUsuariosDependencia($idD){
        $json = file_get_contents(config('WSSinproc') . 'getUsuariosDependencia.php?idD='.$idD);
        $obj = json_decode($json);
        $retorno = $this->GenerarSelect($obj);
        return $retorno;
    }

    public function JefeDependencia($idD){
        $idJefe = file_get_contents(config('WSSinproc') . 'getJefeDelegada.php?idD='.$idD);
        return $idJefe;
    }

    public function ComboEntidadesExternas(){
        $json = file_get_contents(config('WSSinproc') . 'getEntidadesExternas.php');
        $obj = json_decode($json);
        $retorno = $this->GenerarSelect($obj);
        return $retorno;
    }

    public function ClasificacionPQS($sp){
        $clas = file_get_contents(config('WSSinproc') . 'getClasificacionPQS.php?sinproc='.$sp[0].'&idTramite='.$sp[1].'&vigencia='.$sp[2]);
        return $clas;
    }

    public function ComboPMR($idD){
        $json = file_get_contents(config('WSSinproc') . 'getPMR.php?idD='.$idD);
        $obj = json_decode($json);
        $retorno = $this->GenerarSelect($obj);
        return $retorno;
    }

    public function HabilitarPMR($sp){
        $clas = file_get_contents(config('WSSinproc') . 'getHabilitarPMR.php?sinproc='.$sp[0].'&idTramite='.$sp[1].'&vigencia='.$sp[2].'&idD='.$sp[3]);
        return $clas;
    }

    public function ChecarSinproc($cedula, $sinproc){
        $retorno = false;
        $json = file_get_contents(config('WSSinproc') . 'getPendientes.php?idFunc='.$cedula);
        $obj = json_decode($json);
        foreach ($obj as $item) {
            if ($item->sinprocID == $sinproc) {
                $retorno = true;
            }
        }
        return $retorno;
    }

    public function UsuariosSinproc(){
        $json = file_get_contents(config('WSSinproc') . 'getUsuariosMP.php');
        $retorno = json_decode($json);
        return $retorno;
    }

    public function crear_notificacion($id, $nvl1, $nvl2){
        $temp = array('id_usuario' => $id, 'id_nievel1' => $nvl1, 'id_nievel2' => $nvl2);
        Data_Notificaciones::create($temp);
    }

    public function eliminar_notificacion($nvl1, $nvl2){
        Data_Notificaciones::where('id_nievel1', $nvl1)->where('id_nievel2', $nvl2)->delete();
    }

    public function HistoricoActuaciones($sp){
        $clas = file_get_contents(config('WSSinproc') . 'getHistoriocoTramite.php?sinproc='.$sp[0].'&idTramite='.$sp[1].'&vigencia='.$sp[2]);
        return $clas;
    }

}
