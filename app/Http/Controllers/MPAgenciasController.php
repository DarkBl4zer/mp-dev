<?php

namespace App\Http\Controllers;
date_default_timezone_set('America/Bogota');

use App\Models\Data_Agencia_Especial;
use App\Models\Data_Notificaciones;
use App\Models\Para_Criterio_Creacion;
use App\Models\Para_Delegada;
use App\Models\Para_Delito;
use App\Models\Para_Despacho;
use App\Models\Para_Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class MPAgenciasController extends Controller
{
    public static function estoy_logeado(){
        if (Session::has('UsuarioMp')){
            return true;
        } else{
            return false;
        }
    }

    public function inicio_coordinador(){
        if ($this->estoy_logeado()) {
            $sesion = Session::get('UsuarioMp');
            $id = $sesion[0]['id'];
            $noti = Data_Notificaciones::where('id_usuario', $id)->where('id_nievel1', 1)->get();
            $festivos = $this->Festivos();
            return view('coordinador.inicio', compact('noti', 'festivos'));
        } else {
            return redirect('login');
        }
    }

    public function tabla(){
        $retorno = Data_Agencia_Especial::where('eliminado', false)->get();
        for ($i=0; $i < count($retorno); $i++) { 
            $retorno[$i]['numero_agencia_especial'] = sprintf("%03d", $retorno[$i]['numero_agencia_especial']);
            $retorno[$i]['nombre_ministerio'] = Para_Usuarios::where('valor', $retorno[$i]['nombre_ministerio'])->first()->nombre;
            $idD = $retorno[$i]['delegada'];
            $retorno[$i]['delegada'] = Para_Delegada::where('valor', $retorno[$i]['delegada'])->first()->nombre;
            $despacho = Para_Despacho::where('valor', $retorno[$i]['despacho_judicial'])->first();
            $retorno[$i]['despacho_judicial'] = $despacho->codigo . ' -- ' . $despacho->nombre;
            $retorno[$i]['justificacion'] = base64_decode($retorno[$i]['justificacion']);
            $btnEdit = '<button type="button" class="btn btn-primary" onclick="Editar(' . $retorno[$i]['id'] . ');" data-toggle="tooltip" data-html="true" title="<b><u>Editar agencia Especial</u></b>"><i class="fas fa-pencil-alt"></i></button>';
            $btnGen = '<a href="/agencias/generarword/' . $retorno[$i]['id'] . '" class="btn btn-primary" data-toggle="tooltip" data-html="true" title="<b><u>Generar constitución AE</u></b>"><i class="fas fa-download"></i></a>';
            $btnVer = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ', ' . $idD . ');" data-toggle="tooltip" data-html="true" title="<b><u>Ver informes AE</u></b>"><i class="fas fa-eye"></i></button>';
            $btnFin = '<button type="button" class="btn btn-primary" onclick="Finalizar(' . $retorno[$i]['id'] . ');" data-toggle="tooltip" data-html="true" title="<b><u>Finalizar AE</u></b>"><i class="fas fa-door-closed"></i></button>';
            if ($retorno[$i]['estado'] == 1) {
                $retorno[$i]['btn_acciones'] = $btnEdit.' '.$btnGen;
            }
            if ($retorno[$i]['estado'] == 2) {
                $retorno[$i]['btn_acciones'] = $btnGen.' '.$btnVer;
            }
            if ($retorno[$i]['estado'] == 3) {
                $retorno[$i]['btn_acciones'] = $btnGen.' '.$btnVer.' '.$btnFin;
            }
            if ($retorno[$i]['estado'] == 4) {
                $retorno[$i]['btn_acciones'] = $btnVer;
            }
        }
        return $retorno;
    }

    public function modal_coordinador(){
        $id_disponible = 1;
        $algo = Data_Agencia_Especial::orderBy('numero_agencia_especial', 'desc')->get();
        if (count($algo)>0) {
            $temp = $algo[0]['numero_agencia_especial'];
            $id_disponible = $temp + 1;
        }
        $parametricas['delegada'] = $this->GenerarSelect(Para_Delegada::where('eliminado', false)->get());
        $parametricas['despacho'] = $this->GenerarSelect(Para_Despacho::where('eliminado', false)->get(), true);
        $parametricas['adecuacion'] = $this->GenerarSelect(Para_Delito::where('eliminado', false)->get(), true);
        $parametricas['criterio'] = $this->GenerarSelect(Para_Criterio_Creacion::where('eliminado', false)->get());

        return view('coordinador.crear_agencia', compact('parametricas', 'id_disponible'));
    }

    public function cambio_tipo_actuacion(Request $request){
        $parametros = $request->all();
        $nombre_ministerio = Para_Usuarios::where('eliminado', false)->where('id_rol', $parametros['ta'])->get();
        $retorno = array('nombre_ministerio' => $this->GenerarSelect($nombre_ministerio));
        return $retorno;
    }

    public function guardar(Request $request){
        $sesion = Session::get('UsuarioMp');
        $cc = $sesion[0]['cedula'];
        $campos = $request->all();
        $campos['usuario_crea'] = $cc;
        $sp = explode('/', $campos['fecha_creacion']);
        $campos['fecha_creacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
        //dd($campos);
        $existe = Data_Agencia_Especial::where('numero_agencia_especial', $campos['numero_agencia_especial'])->count();
        if ($existe > 0) {
            $id = Data_Agencia_Especial::where('numero_agencia_especial', $campos['numero_agencia_especial'])->first()->id;
            Data_Agencia_Especial::find($id)->update($campos);
            $this->eliminar_notificacion(1, $id);
            $mp = Para_Usuarios::where('valor', $campos['nombre_ministerio'])->first();
            $this->crear_notificacion($mp->id, 1, $id);
            return redirect('coordinador')->with('success', 'Registro de Agencia especial actualizado correctamente en el sistema.');
        } else {
            $idAE = Data_Agencia_Especial::create($campos)->id;
            $mp = Para_Usuarios::where('valor', $campos['nombre_ministerio'])->first();
            $this->crear_notificacion($mp->id, 1, $idAE);
            return redirect('coordinador')->with('success', 'Registro de Agencia especial creado correctamente en el sistema.');
        }
    }

    public function modal_editar_coordinador(Request $request){
        $consulta = $request->all();
        $agencia = Data_Agencia_Especial::where('eliminado', false)->where('id', $consulta['id'])->first();
        $parametricas['delegada'] = $this->GenerarSelect(Para_Delegada::where('eliminado', false)->get(), false, $agencia->delegada);
        $parametricas['despacho'] = $this->GenerarSelect(Para_Despacho::where('eliminado', false)->get(), true, $agencia->despacho_judicial);
        $parametricas['adecuacion'] = $this->GenerarSelect(Para_Delito::where('eliminado', false)->get(), true, $agencia->adecuacion_tipica);
        $parametricas['criterio'] = $this->GenerarSelect(Para_Criterio_Creacion::where('eliminado', false)->get(), false, $agencia->criterio_creacion);
        $agencia->justificacion = base64_decode($agencia->justificacion);
        $despacho = Para_Despacho::where('valor', $agencia->despacho_judicial)->first();
        $agencia->despacho_judicial = $despacho->codigo . ' -- ' . $despacho->nombre;
        $agencia->fecha_creacion = Carbon::parse($agencia->fecha_creacion)->format('d/m/Y');
        return view('coordinador.editar_agencia', compact('parametricas', 'agencia'));
    }

    public function finalizar_guardar(Request $request){
        $sesion = Session::get('UsuarioMp');
        $cc = $sesion[0]['cedula'];
        $campos = $request->all();
        $campos['usuario_crea'] = $cc;
        $nombreU = $sesion[0]['nombre'];

        $date = Carbon::now()->format('d/m/Y');
        $jus_anterior = base64_decode(Data_Agencia_Especial::where('id', $campos['idAE'])->first()->justificacion_fin);
        $jus_nueva = base64_decode($campos['justificacion_fin']);
        $campos['justificacion_fin'] = base64_encode($jus_anterior . "||".$nombreU."<br>\n[".$date."]((" . $jus_nueva);
        Data_Agencia_Especial::find($campos['idAE'])->update($campos);
        if ($campos['estado'] == 2) {
            $this->eliminar_notificacion(1, $campos['idAE']);
            $ccMp = Data_Agencia_Especial::where('id', $campos['idAE'])->first()->nombre_ministerio;
            $mp = Para_Usuarios::where('valor', $ccMp)->first();
            $this->crear_notificacion($mp->id, 1, $campos['idAE']);
        } else{
            $this->eliminar_notificacion(1, $campos['idAE']);
        }
        return redirect('coordinador')->with('success', 'Agencia especial actuializada correctamente en el sistema.');
    }

    public function historial(Request $request){
        $campos = $request->all();
        $jus_anterior = base64_decode(Data_Agencia_Especial::where('id', $campos['idAE'])->first()->justificacion_fin);
        $sp1 = explode('||', $jus_anterior);
        $html = '<table class="table table-bordered table-striped" style="font-size: 13px;"><thead class="thead-light"><tr><th style="padding: 5px; width: 150px;">USUARIO</th><th style="padding: 5px;">JUSTIFICACIÓN</th></tr></thead><tbody>';
        for ($i=1; $i < count($sp1); $i++) { 
            $sp2 = explode('((', $sp1[$i]);
            $html .= '<tr><td style="padding: 5px;">'.$sp2[0].'</td><td style="padding: 5px;">'.$sp2[1].'</td></tr>';
        }
        $html .= '</tbody></table>';
        return $html;
    }

}
