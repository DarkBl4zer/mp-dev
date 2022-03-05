<?php

namespace App\Http\Controllers;
date_default_timezone_set('America/Bogota');

use App\Models\Data_Notificaciones;
use App\Models\Para_Roles;
use App\Models\Para_Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MpController extends Controller
{
    public static function estoy_logeado(){
        if (Session::has('UsuarioMp')){
            return true;
        } else{
            return false;
        }
    }

    public function index(){
        if ($this->estoy_logeado()) {
            $sesion = Session::get('UsuarioMp');
            $rol = $sesion[0]['rol'];
            $id = $sesion[0]['id'];
            $noti = Data_Notificaciones::where('id_usuario', $id)->get();
            $btnO = false; $btnP = false; $btnA = false; $btnE = false; $btnN = false; $btnC = false; $btnG = false; $btnX = false;
            if ($rol == 1 || $rol == 2) {
                $btnO = true; $btnP = true; $btnA = true; $btnE = true; $btnX = true;
            }
            if ($rol == 3 || $rol == 4 || $rol == 5) {
                $btnO = true; $btnP = true; $btnN = true; $btnX = true;
            }
            if ($rol == 7 || $rol == 6) {
                $btnO = true; $btnP = true; $btnE = false; $btnX = true;
            }
            if ($rol == 8) {
                $btnO = true; $btnP = true; $btnN = false; $btnX = true;
            }
            if ($rol == 9) {
                $btnA = true; $btnX = true;
            }
            if ($rol == 10) {
                $btnG = true;
                $btnX = true;
            }
            return view('index', compact('rol','btnO','btnP','btnA','btnE','btnN', 'btnC', 'btnG', 'btnX', 'noti'));
        } else {
            return redirect('login');
        }
    }

    public function login(){
        $roles = Para_Roles::get();
        return view('login', compact('roles'));
    }

    public function logout(){
        Session::forget('UsuarioMp');
        //return redirect(config('LogoutSinproc'));
        return redirect('login');
    }

    public function logear(Request $request){
        $todos = $request->all();
        $usuario = Para_Usuarios::where('eliminado', false)->where('id_rol', $todos['RolUsuario'])->first();
        $sesion = array(
            'rol' => $todos['RolUsuario'],
            'delegada' => 10,
            'nombre_delegada' => 'TIC',
            'cedula' => $usuario->valor,
            'email' => 'desinproc@desinproc.com',
            'nombre' => $usuario->nombre,
            'id' => $usuario->id
        );
        Session::push('UsuarioMp', $sesion);
        return redirect('/');
    }

    public function logear_sinproc($cc){
        $existe = false;
        $usuario = array();
        $usuarios = Para_Usuarios::where('eliminado', false)->get();
        foreach ($usuarios as $item) {
            if ($item->valor == $cc) {
                if ($item->id_rol != 0) {
                    $existe = true;
                    $usuario = array(
                        'rol' => $item->id_rol,
                        'delegada' => $item->idd,
                        'nombre_delegada' => $item->nombred,
                        'cedula' => $item->valor,
                        'email' => $item->email,
                        'nombre' => $item->nombre,
                        'id' => $item->id
                    );
                }
            }
        }
        if ($existe) {
            Session::push('UsuarioMp', $usuario);
            return redirect('/');
        } else{
            return $this->MostrarError('Usted no tiene permisos para acceder al módulo. Por favor comuníquese con el/la Delegado(a) para que le sean asignado estos permisos.');
        }
    }

    //==================================================== WebService SINPROC ====================================================

    public function sinproc_actuacion($tipo_mp, $respuesta){
        $redirect = "";
        if ($tipo_mp == 1) {
            $redirect = 'penales1/parte';
        }
        if ($tipo_mp == 2) {
            $redirect = 'penales2/parte';
        }
        if ($tipo_mp == 3) {
            $redirect = 'movilidad/parte';
        }
        if ($tipo_mp == 4) {
            $redirect = 'juzgados/parte';
        }
        if ($tipo_mp == 5) {
            $redirect = 'segunda/parte';
        }
        $sp = explode('||', $respuesta);
        if ($sp[1] == "0") {
            return redirect($redirect)->with('success', 'Actuacion registrada correctamente en SINPROC ' . $sp[0]);
        } else {
            return redirect($redirect)->with('danger', $sp[2] . ' en SINPROC ' . $sp[0]);
        }
    }

    public function sinproc_remision($tipo_mp, $respuesta){
        $redirect = "";
        if ($tipo_mp == 1) {
            $redirect = 'penales1/parte';
        }
        if ($tipo_mp == 2) {
            $redirect = 'penales2/parte';
        }
        if ($tipo_mp == 3) {
            $redirect = 'movilidad/parte';
        }
        if ($tipo_mp == 4) {
            $redirect = 'juzgados/parte';
        }
        if ($tipo_mp == 5) {
            $redirect = 'segunda/parte';
        }
        $sp = explode('||', $respuesta);
        if ($sp[1] == "0") {
            return redirect($redirect)->with('success', 'Remision registrada correctamente en SINPROC ' . $sp[0]);
        } else {
            return redirect($redirect)->with('danger', $sp[2] . ' en SINPROC ' . $sp[0]);
        }
    }

    public function sinproc_archivo($tipo_mp, $respuesta){
        $redirect = "";
        if ($tipo_mp == 1) {
            $redirect = 'penales1/parte';
        }
        if ($tipo_mp == 2) {
            $redirect = 'penales2/parte';
        }
        if ($tipo_mp == 3) {
            $redirect = 'movilidad/parte';
        }
        if ($tipo_mp == 4) {
            $redirect = 'juzgados/parte';
        }
        if ($tipo_mp == 5) {
            $redirect = 'segunda/parte';
        }
        $sp = explode('||', $respuesta);
        if ($sp[1] == "0") {
            return redirect($redirect)->with('success', 'Archivo registrada correctamente en SINPROC ' . $sp[0]);
        } else {
            return redirect($redirect)->with('danger', $sp[2] . ' en SINPROC ' . $sp[0]);
        }
    }

    public function sinproc_detalle(Request $request){
        $campos = $request->all();
        $sp = explode(';', $campos['tk']);
        $retorno = $this->DetalleSinproc($sp);
        return $retorno;
    }

    public function sinproc_modal_act(Request $request){
        $sesion = Session::get('UsuarioMp');
        $cedula = $sesion[0]['cedula'];

        $consulta = $request->all();
        $tk = explode(';', $consulta['tk']);
        $tipoActuacion = $this->ComboTipoActuacion($tk[1]);
        return view('penales1.parte_actuacion', compact('tk', 'tipoActuacion', 'cedula'));
    }

    public function sinproc_modal_rem(Request $request){
        $sesion = Session::get('UsuarioMp');
        $cedula = $sesion[0]['cedula'];
        $delegada = $sesion[0]['delegada'];

        $consulta = $request->all();
        $tk = explode(';', $consulta['tk']);
        $dependencias = $this->ComboDependencias($tk[1]);
        $usuarios_dependencia = $this->ComboUsuariosDependencia($delegada);
        return view('penales1.parte_remision', compact('tk', 'dependencias', 'usuarios_dependencia', 'cedula', 'delegada'));
    }

    public function sinproc_jefe_delegada(Request $request){
        $parametros = $request->all();
        $retorno = $this->JefeDependencia($parametros['idD']);
        return $retorno;
    }

    public function sinproc_modal_arc(Request $request){
        $sesion = Session::get('UsuarioMp');
        $cedula = $sesion[0]['cedula'];
        $delegada = $sesion[0]['delegada'];

        $consulta = $request->all();
        $tk = explode(';', $consulta['tk']);
        $entExternas = $this->ComboEntidadesExternas($tk[1]);
        $clasificacionPQS = $this->ClasificacionPQS($tk);
        $pmr = $this->ComboPMR($delegada);
        $tk[3] = $delegada;
        $habilitaPMR = explode('||', $this->HabilitarPMR($tk));
        return view('penales1.parte_archivo', compact('tk', 'entExternas', 'clasificacionPQS', 'cedula', 'habilitaPMR', 'pmr'));
    }

    public function sinproc_modal_hist(Request $request){
        $consulta = $request->all();
        $tk = explode(';', $consulta['tk']);
        $historico = $this->HistoricoActuaciones($tk);
        return $historico;
    }

}
