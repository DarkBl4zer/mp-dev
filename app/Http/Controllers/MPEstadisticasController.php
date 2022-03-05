<?php

namespace App\Http\Controllers;
date_default_timezone_set('America/Bogota');

use App\Models\Data_Agencia_Especial;
use App\Models\Data_Agencia_Informe;
use App\Models\Data_Denunciados;
use App\Models\Data_Penales_Dos;
use App\Models\Data_Penales_Uno;
use App\Models\Data_Policivos;
use App\Models\Para_Actuacion;
use App\Models\Para_Autoridad_Admin;
use App\Models\Para_Clase_Diligencia;
use App\Models\Para_Clase_Policivo;
use App\Models\Para_Criterio_Creacion;
use App\Models\Para_Criterio_Intervencion;
use App\Models\Para_Delegada;
use App\Models\Para_Delito;
use App\Models\Para_Despacho;
use App\Models\Para_DespachoJ;
use App\Models\Para_Estado_Audiencia;
use App\Models\Para_Tipo_MP;
use App\Models\Para_Tipo_Victima;
use App\Models\Para_Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class MPEstadisticasController extends Controller
{

    public static function estoy_logeado(){
        if (Session::has('UsuarioMp')){
            return true;
        } else{
            return false;
        }
    }

    public function index(){
        $sesion = Session::get('UsuarioMp');
        $rol = $sesion[0]['rol'];
        return view('estadisticas.informes', compact('rol'));
    }

    public function lista(){
        $sesion = Session::get('UsuarioMp');
        $rol = $sesion[0]['rol'];
        return view('estadisticas.informes', compact('rol'));
    }

    public function informe_general(Request $request){
        $sesion = Session::get('UsuarioMp');
        $rol = $sesion[0]['rol'];
        $cedula = $sesion[0]['cedula'];

        $parametros = $request->all();
        $informe = array();
        $informe['tipo'] = $parametros['tipo'];
        if ($parametros['tipo'] == 1) {
            $general = array();
            $informe['titulo'] = 'INFORME GENERAL PENALES1';
            $actuaciones = Para_Actuacion::whereIn('id_tipo_mp', [1,6])->get();
            $sum_oficio = 0;
            $sum_parte = 0;
            $sum_total = 0;
            foreach ($actuaciones as $item) {
                if ($rol == 1) {
                    $oficio = Data_Penales_Uno::where('eliminado', false)->where('usuario_crea', $cedula)->whereIn('tipo_formulario', [1,3])->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Penales_Uno::where('eliminado', false)->where('usuario_crea', $cedula)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                } else {
                    $oficio = Data_Penales_Uno::where('eliminado', false)->whereIn('tipo_formulario', [1,3])->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Penales_Uno::where('eliminado', false)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                }
                $total = $oficio + $parte;
                $ta = (substr($item->nombre, 0, 2) == '0_') ? str_replace("0_", "", $item->nombre) : $item->nombre;
                $arr = array(
                    'id_actuacion' => $item->valor,
                    'actuacion' => $ta,
                    'oficio' => $oficio,
                    'parte' => $parte,
                    'total' => $total
                );
                array_push($general, $arr);
                $sum_oficio = $sum_oficio + $oficio;
                $sum_parte = $sum_parte + $parte;
                $sum_total = $sum_total + $total;
            }
            $arr = array(
                'id_actuacion' => 999999,
                'actuacion' => 'TOTAL',
                'oficio' => $sum_oficio,
                'parte' => $sum_parte,
                'total' => $sum_total
            );
            array_push($general, $arr);
            $informe['general'] = $general;
        }
        if ($parametros['tipo'] == 2) {
            $general = array();
            $informe['titulo'] = 'INFORME GENERAL PENALES2';
            $actuaciones = Para_Actuacion::whereIn('id_tipo_mp', [2,6])->get();
            $sum_oficio = 0;
            $sum_parte = 0;
            $sum_total = 0;
            foreach ($actuaciones as $item) {
                if ($rol == 2) {
                    $oficio = Data_Penales_Dos::where('eliminado', false)->where('usuario_crea', $cedula)->whereIn('tipo_formulario', [1,3])->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Penales_Dos::where('eliminado', false)->where('usuario_crea', $cedula)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                } else {
                    $oficio = Data_Penales_Dos::where('eliminado', false)->whereIn('tipo_formulario', [1,3])->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Penales_Dos::where('eliminado', false)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                }
                $total = $oficio + $parte;
                $ta = (substr($item->nombre, 0, 2) == '0_') ? str_replace("0_", "", $item->nombre) : $item->nombre;
                $arr = array(
                    'id_actuacion' => $item->valor,
                    'actuacion' => $ta,
                    'oficio' => $oficio,
                    'parte' => $parte,
                    'total' => $total
                );
                array_push($general, $arr);
                $sum_oficio = $sum_oficio + $oficio;
                $sum_parte = $sum_parte + $parte;
                $sum_total = $sum_total + $total;
            }
            $arr = array(
                'id_actuacion' => 999999,
                'actuacion' => 'TOTAL',
                'oficio' => $sum_oficio,
                'parte' => $sum_parte,
                'total' => $sum_total
            );
            array_push($general, $arr);
            $informe['general'] = $general;
        }
        if ($parametros['tipo'] == 3) {
            $general = array();
            $informe['titulo'] = 'INFORME GENERAL MOVILIDAD';
            $actuaciones = Para_Actuacion::whereIn('id_tipo_mp', [3])->get();
            $sum_oficio = 0;
            $sum_parte = 0;
            $sum_total = 0;
            foreach ($actuaciones as $item) {
                if ($rol == 3) {
                    $oficio = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 3)->where('usuario_crea', $cedula)->where('tipo_formulario', 1)->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 3)->where('usuario_crea', $cedula)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                } else {
                    $oficio = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 3)->where('tipo_formulario', 1)->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 3)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                }
                $total = $oficio + $parte;
                $ta = (substr($item->nombre, 0, 2) == '0_') ? str_replace("0_", "", $item->nombre) : $item->nombre;
                $arr = array(
                    'id_actuacion' => $item->valor,
                    'actuacion' => $ta,
                    'oficio' => $oficio,
                    'parte' => $parte,
                    'total' => $total
                );
                array_push($general, $arr);
                $sum_oficio = $sum_oficio + $oficio;
                $sum_parte = $sum_parte + $parte;
                $sum_total = $sum_total + $total;
            }
            $arr = array(
                'id_actuacion' => 999999,
                'actuacion' => 'TOTAL',
                'oficio' => $sum_oficio,
                'parte' => $sum_parte,
                'total' => $sum_total
            );
            array_push($general, $arr);
            $informe['general'] = $general;
        }
        if ($parametros['tipo'] == 4) {
            $general = array();
            $informe['titulo'] = 'INFORME GENERAL JUZGADOS';
            $actuaciones = Para_Actuacion::whereIn('id_tipo_mp', [4])->get();
            $sum_oficio = 0;
            $sum_parte = 0;
            $sum_total = 0;
            foreach ($actuaciones as $item) {
                if ($rol == 4) {
                    $oficio = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 4)->where('usuario_crea', $cedula)->where('tipo_formulario', 1)->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 4)->where('usuario_crea', $cedula)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                } else {
                    $oficio = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 4)->where('tipo_formulario', 1)->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 4)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                }
                $total = $oficio + $parte;
                $ta = (substr($item->nombre, 0, 2) == '0_') ? str_replace("0_", "", $item->nombre) : $item->nombre;
                $arr = array(
                    'id_actuacion' => $item->valor,
                    'actuacion' => $ta,
                    'oficio' => $oficio,
                    'parte' => $parte,
                    'total' => $total
                );
                array_push($general, $arr);
                $sum_oficio = $sum_oficio + $oficio;
                $sum_parte = $sum_parte + $parte;
                $sum_total = $sum_total + $total;
            }
            $arr = array(
                'id_actuacion' => 999999,
                'actuacion' => 'TOTAL',
                'oficio' => $sum_oficio,
                'parte' => $sum_parte,
                'total' => $sum_total
            );
            array_push($general, $arr);
            $informe['general'] = $general;
        }
        if ($parametros['tipo'] == 5) {
            $general = array();
            $informe['titulo'] = 'INFORME GENERAL SEGUNDA';
            $actuaciones = Para_Actuacion::whereIn('id_tipo_mp', [5])->get();
            $sum_oficio = 0;
            $sum_parte = 0;
            $sum_total = 0;
            foreach ($actuaciones as $item) {
                if ($rol == 5) {
                    $oficio = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 5)->where('usuario_crea', $cedula)->where('tipo_formulario', 1)->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 5)->where('usuario_crea', $cedula)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                } else {
                    $oficio = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 5)->where('tipo_formulario', 1)->where('tipo_actuacion', $item->valor)->count();
                    $parte = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 5)->where('tipo_formulario', 2)->where('tipo_actuacion', $item->valor)->count();
                }
                $total = $oficio + $parte;
                $ta = (substr($item->nombre, 0, 2) == '0_') ? str_replace("0_", "", $item->nombre) : $item->nombre;
                $arr = array(
                    'id_actuacion' => $item->valor,
                    'actuacion' => $ta,
                    'oficio' => $oficio,
                    'parte' => $parte,
                    'total' => $total
                );
                array_push($general, $arr);
                $sum_oficio = $sum_oficio + $oficio;
                $sum_parte = $sum_parte + $parte;
                $sum_total = $sum_total + $total;
            }
            $arr = array(
                'id_actuacion' => 999999,
                'actuacion' => 'TOTAL',
                'oficio' => $sum_oficio,
                'parte' => $sum_parte,
                'total' => $sum_total
            );
            array_push($general, $arr);
            $informe['general'] = $general;
        }
        if ($parametros['tipo'] == 6) {
            $general = array();
            $informe['titulo'] = 'INFORME GENERAL PMR';
            $oficio = Data_Penales_Uno::where('eliminado', false)->where('tipo_formulario', 1)->where('estado_audiencia', '!=', 2)->count();
            $parte = Data_Penales_Uno::where('eliminado', false)->where('tipo_formulario', 2)->where('estado_audiencia', '!=', 2)->count();
            $total = $oficio + $parte;
            $arr = array(
                'id_actuacion' => 1,
                'actuacion' => 'PENALES1',
                'oficio' => $oficio,
                'parte' => $parte,
                'total' => $total
            );
            array_push($general, $arr);
            $oficio = Data_Penales_Dos::where('eliminado', false)->where('tipo_formulario', 1)->where('estado_audiencia', '!=', 2)->count();
            $parte = Data_Penales_Dos::where('eliminado', false)->where('tipo_formulario', 2)->where('estado_audiencia', '!=', 2)->count();
            $total = $oficio + $parte;
            $arr = array(
                'id_actuacion' => 2,
                'actuacion' => 'PENALES2',
                'oficio' => $oficio,
                'parte' => $parte,
                'total' => $total
            );
            array_push($general, $arr);
            $oficio = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 3)->where('tipo_formulario', 1)->count();
            $parte = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 3)->where('tipo_formulario', 2)->count();
            $total = $oficio + $parte;
            $arr = array(
                'id_actuacion' => 3,
                'actuacion' => 'MOVILIDAD',
                'oficio' => $oficio,
                'parte' => $parte,
                'total' => $total
            );
            array_push($general, $arr);
            $oficio = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 4)->where('tipo_formulario', 1)->count();
            $parte = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 4)->where('tipo_formulario', 2)->count();
            $total = $oficio + $parte;
            $arr = array(
                'id_actuacion' => 4,
                'actuacion' => 'JUZGADOS',
                'oficio' => $oficio,
                'parte' => $parte,
                'total' => $total
            );
            array_push($general, $arr);
            $oficio = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 5)->where('tipo_formulario', 1)->count();
            $parte = Data_Policivos::where('eliminado', false)->where('id_tipo_mp', 5)->where('tipo_formulario', 2)->count();
            $total = $oficio + $parte;
            $arr = array(
                'id_actuacion' => 5,
                'actuacion' => 'SEGUNDA',
                'oficio' => $oficio,
                'parte' => $parte,
                'total' => $total
            );
            array_push($general, $arr);
            $informe['general'] = $general;
        }
        if ($parametros['tipo'] == 7) {
            $general = array();
            $informe['titulo'] = 'INFORME GENERAL AGENCIAS ESPECIALES';
            $finalizadas1 = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 1)->where('estado', 4)->count();
            $abiertas1 = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 1)->where('estado', '!=', 4)->count();
            $arr = array(
                'id_actuacion' => "'agencia_PENALES1'",
                'actuacion' => 'PENALES 1',
                'oficio' => $abiertas1,
                'parte' => $finalizadas1,
                'total' => $abiertas1 + $finalizadas1
            );
            array_push($general, $arr);
            $finalizadas2 = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 2)->where('estado', 4)->count();
            $abiertas2 = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 2)->where('estado', '!=', 4)->count();
            $arr = array(
                'id_actuacion' => "'agencia_PENALES2'",
                'actuacion' => 'PENALES 2',
                'oficio' => $abiertas2,
                'parte' => $finalizadas2,
                'total' => $abiertas2 + $finalizadas2
            );
            array_push($general, $arr);
            $abiertas3 = $abiertas1 + $abiertas2;
            $finalizadas3 = $finalizadas1 + $finalizadas2;
            $arr = array(
                'id_actuacion' => "'agencia_TOTAL'",
                'actuacion' => 'TOTAL',
                'oficio' => $abiertas3,
                'parte' => $finalizadas3,
                'total' => $abiertas3 + $finalizadas3
            );
            array_push($general, $arr);
            $informe['general'] = $general;
        }
        return view('estadisticas.informe_general', compact('informe'));
    }
    
    public function informe_detalle(Request $request){
        $sesion = Session::get('UsuarioMp');
        $rol = $sesion[0]['rol'];

        $parametros = $request->all();
        if ($parametros['delegada'] == 6) {
            return view('estadisticas.informe_detalle6', compact('parametros', 'rol'));
        } elseif ($parametros['delegada'] == 7) {
            $sp = explode('_', $parametros['actuacion']);
            if ($parametros['tipo'] == 1) {
                $parametros['nombre_actuacion'] = $sp[1]." ABIERTAS";
            } elseif($parametros['tipo'] == 2) {
                $parametros['nombre_actuacion'] = $sp[1]." FINALIZADAS";
            } else{
                $parametros['nombre_actuacion'] = $sp[1]." TOTALES";
            }
            return view('estadisticas.informe_detalle7', compact('parametros', 'rol'));
        } else{
            if ($parametros['actuacion'] != 999999) {
                $ta = Para_Actuacion::where('valor', $parametros['actuacion'])->first()->nombre;
                $parametros['nombre_actuacion'] = (substr($ta, 0, 2) == '0_') ? str_replace("0_", "", $ta) : $ta;
            } else {
                if ($parametros['tipo'] == 1) {
                    $parametros['nombre_actuacion'] = "TOTAL OFICIO";
                } elseif($parametros['tipo'] == 2) {
                    $parametros['nombre_actuacion'] = "TOTAL PARTE";
                } else{
                    $parametros['nombre_actuacion'] = "TOTALES";
                }
            }
            if ($parametros['delegada'] > 3) {
                return view('estadisticas.informe_detalle3', compact('parametros', 'rol'));
            } else {
                return view('estadisticas.informe_detalle'.$parametros['delegada'], compact('parametros', 'rol'));
            }
        }
    }

    public function informe_detalle1_datos(Request $request){
        $sesion = Session::get('UsuarioMp');
        $rol = $sesion[0]['rol'];
        $cedula = $sesion[0]['cedula'];

        $parametros = $request->all();
        $retorno = array();
        $obj1 = $this->ComboSexo(true);
        $obj2 = $this->ComboIdentidad(true);
        $obj3 = $this->ComboOrientacion(true);
        $obj4 = $this->ComboPaises(true);
        if ($parametros['tipo'] != 3) {
            if ($parametros['actuacion'] == 999999) {
                if ($rol == 1) {
                    if ($parametros['tipo'] == 1) {
                        $retorno = Data_Penales_Uno::whereIn('tipo_formulario', [1,3])->where('usuario_crea', $cedula)->get();
                    } else{
                        $retorno = Data_Penales_Uno::where('tipo_formulario', $parametros['tipo'])->where('usuario_crea', $cedula)->get();
                    }
                } else {
                    if ($parametros['tipo'] == 1) {
                        $retorno = Data_Penales_Uno::whereIn('tipo_formulario', [1,3])->get();
                    } else{
                        $retorno = Data_Penales_Uno::where('tipo_formulario', $parametros['tipo'])->get();
                    }
                }
            } else {
                if ($rol == 1) {
                    if ($parametros['tipo'] == 1) {
                        $retorno = Data_Penales_Uno::whereIn('tipo_formulario', [1,3])->where('tipo_actuacion', $parametros['actuacion'])->where('usuario_crea', $cedula)->get();
                    } else{
                        $retorno = Data_Penales_Uno::where('tipo_formulario', $parametros['tipo'])->where('tipo_actuacion', $parametros['actuacion'])->where('usuario_crea', $cedula)->get();
                    }
                } else {
                    if ($parametros['tipo'] == 1) {
                        $retorno = Data_Penales_Uno::whereIn('tipo_formulario', [1,3])->where('tipo_actuacion', $parametros['actuacion'])->get();
                    } else{
                        $retorno = Data_Penales_Uno::where('tipo_formulario', $parametros['tipo'])->where('tipo_actuacion', $parametros['actuacion'])->get();
                    }
                }
            }
        } else {
            if ($parametros['actuacion'] == 999999) {
                if ($rol == 1) {
                    $retorno = Data_Penales_Uno::where('usuario_crea', $cedula)->get();
                } else {
                    $retorno = Data_Penales_Uno::get();
                }
            } else {
                if ($rol == 1) {
                    $retorno = Data_Penales_Uno::where('tipo_actuacion', $parametros['actuacion'])->where('usuario_crea', $cedula)->get();
                } else {
                    $retorno = Data_Penales_Uno::where('tipo_actuacion', $parametros['actuacion'])->get();
                }
            }
        }
        foreach ($retorno as $item) {
            if ($item->tipo_formulario == 1) {
                $item->tipo_formulario = 'DE OFICIO';
            } elseif ($item->tipo_formulario == 2) {
                $item->tipo_formulario = 'DE PARTE';
            } else{
                $item->tipo_formulario = 'AGENCIA ESPECIAL #'.sprintf("%03d", $item->agencia_especial);
            }
            if (!is_null($item->act_sinproc)) {
                $temp = str_replace("- ", "", $item->act_sinproc);
                $sp1 = explode('||', $temp);
                $sp2 = explode(';', $sp1[1]);
                $item->act_sinproc = $sp1[0].'<br>Sinproc: '.$sp2[0].'<br>Tramite: '.$sp2[1].'<br>Vigencia: '.$sp2[2];
            }
            $denunciados = Data_Denunciados::where('id_tipo_mp', 1)->where('id_actuacion', $item->id)->get();
            $rdenunciados = "<ul>";
            foreach ($denunciados as $den) {
                for ($x=0; $x < count($obj1); $x++) { 
                    if ($obj1[$x]->valor == $den->sexo) {
                        $den->sexo = $obj1[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj2); $x++) { 
                    if ($obj2[$x]->valor == $den->identidad) {
                        $den->identidad = $obj2[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj3); $x++) { 
                    if ($obj3[$x]->valor == $den->orientacion) {
                        $den->orientacion = $obj3[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj4); $x++) { 
                    if ($obj4[$x]->valor == $den->nacionalidad) {
                        $den->nacionalidad = $obj4[$x]->nombre;
                    }
                }
                $rdenunciados .= '<li>'.$den->cantidad.', '.$den->sexo.', '.$den->identidad.', '.$den->orientacion.', '.$den->nacionalidad.'</li><xsl:text>&#xA;</xsl:text>'; 
            }
            $item->datos_denunciados = $rdenunciados.'</ul>';
            $ta = Para_Actuacion::where('valor', $item->tipo_actuacion)->first()->nombre;
            $item->tipo_actuacion = (substr($ta, 0, 2) == '0_') ? str_replace("0_", "", $ta) : $ta;
            $item->clase_diligencia = Para_Clase_Diligencia::where('valor', $item->clase_diligencia)->first()->nombre;
            if (!is_null($item->estado_audiencia)) {
                $item->estado_audiencia = Para_Estado_Audiencia::where('valor', $item->estado_audiencia)->first()->nombre;
            }
            $item->criterio_intervencion = Para_Criterio_Intervencion::where('valor', $item->criterio_intervencion)->first()->nombre;
            $despacho = Para_Despacho::where('valor', $item->despacho_judicial)->first();
            $item->despacho_judicial = $despacho->codigo . ' -- ' . $despacho->nombre;
            $item->delito = Para_Delito::where('valor', $item->delito)->first()->nombre;
            $item->fecha_actuacion = Carbon::parse($item->fecha_actuacion)->format('d/m/Y');
            $item->observaciones = base64_decode($item->observaciones);
            if (!is_null($item->archivo_or)) {
                $item->link_archivo = '<a href="/penales1/archivo/'.$item->archivo_dt.'">'.$item->archivo_or.'</a>';
            } else{
                $item->link_archivo = '';
            }
            if ($item->eliminado == 0) {
                $item->eliminado = 'NO';
            } else {
                $item->eliminado = 'SI';
            }
            $item->cc_usuario_crea = $item->usuario_crea;
            $item->usuario_crea = Para_Usuarios::where('valor', $item->usuario_crea)->first()->nombre;
            $item->fecha_crea = Carbon::parse($item->created_at)->format('d/m/Y');
        }
        return $retorno;
    }

    public function informe_detalle2_datos(Request $request){
        $sesion = Session::get('UsuarioMp');
        $rol = $sesion[0]['rol'];
        $cedula = $sesion[0]['cedula'];

        $parametros = $request->all();
        $retorno = array();
        $obj1 = $this->ComboSexo(true);
        $obj2 = $this->ComboIdentidad(true);
        $obj3 = $this->ComboOrientacion(true);
        $obj4 = $this->ComboPaises(true);
        if ($parametros['tipo'] != 3) {
            if ($parametros['actuacion'] == 999999) {
                if ($rol == 2) {
                    if ($parametros['tipo'] == 1) {
                        $retorno = Data_Penales_Dos::whereIn('tipo_formulario', [1,3])->where('usuario_crea', $cedula)->get();
                    } else{
                        $retorno = Data_Penales_Dos::where('tipo_formulario', $parametros['tipo'])->where('usuario_crea', $cedula)->get();
                    }
                } else {
                    if ($parametros['tipo'] == 1) {
                        $retorno = Data_Penales_Dos::whereIn('tipo_formulario', [1,3])->get();
                    } else{
                        $retorno = Data_Penales_Dos::where('tipo_formulario', $parametros['tipo'])->get();
                    }
                }
            } else {
                if ($rol == 2) {
                    if ($parametros['tipo'] == 1) {
                        $retorno = Data_Penales_Dos::whereIn('tipo_formulario', [1,3])->where('tipo_actuacion', $parametros['actuacion'])->where('usuario_crea', $cedula)->get();
                    } else{
                        $retorno = Data_Penales_Dos::where('tipo_formulario', $parametros['tipo'])->where('tipo_actuacion', $parametros['actuacion'])->where('usuario_crea', $cedula)->get();
                    }
                } else {
                    if ($parametros['tipo'] == 1) {
                        $retorno = Data_Penales_Dos::whereIn('tipo_formulario', [1,3])->where('tipo_actuacion', $parametros['actuacion'])->get();
                    } else{
                        $retorno = Data_Penales_Dos::where('tipo_formulario', $parametros['tipo'])->where('tipo_actuacion', $parametros['actuacion'])->get();
                    }
                }
            }
        } else {
            if ($parametros['actuacion'] == 999999) {
                if ($rol == 2) {
                    $retorno = Data_Penales_Dos::where('usuario_crea', $cedula)->get();
                } else {
                    $retorno = Data_Penales_Dos::get();
                }
            } else {
                if ($rol == 2) {
                    $retorno = Data_Penales_Dos::where('tipo_actuacion', $parametros['actuacion'])->where('usuario_crea', $cedula)->get();
                } else {
                    $retorno = Data_Penales_Dos::where('tipo_actuacion', $parametros['actuacion'])->get();
                }
            }
        }
        foreach ($retorno as $item) {
            if ($item->tipo_formulario == 1) {
                $item->tipo_formulario = 'DE OFICIO';
            } elseif ($item->tipo_formulario == 2) {
                $item->tipo_formulario = 'DE PARTE';
            } else{
                $item->tipo_formulario = 'AGENCIA ESPECIAL #'.sprintf("%03d", $item->agencia_especial);
            }
            if (!is_null($item->act_sinproc)) {
                $temp = str_replace("- ", "", $item->act_sinproc);
                $sp1 = explode('||', $temp);
                $sp2 = explode(';', $sp1[1]);
                $item->act_sinproc = $sp1[0].'<br>Sinproc: '.$sp2[0].'<br>Tramite: '.$sp2[1].'<br>Vigencia: '.$sp2[2];
            }
            $denunciados = Data_Denunciados::where('id_tipo_mp', 2)->where('id_actuacion', $item->id)->get();
            $rdenunciados = "<ul>";
            foreach ($denunciados as $den) {
                for ($x=0; $x < count($obj1); $x++) { 
                    if ($obj1[$x]->valor == $den->sexo) {
                        $den->sexo = $obj1[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj2); $x++) { 
                    if ($obj2[$x]->valor == $den->identidad) {
                        $den->identidad = $obj2[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj3); $x++) { 
                    if ($obj3[$x]->valor == $den->orientacion) {
                        $den->orientacion = $obj3[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj4); $x++) { 
                    if ($obj4[$x]->valor == $den->nacionalidad) {
                        $den->nacionalidad = $obj4[$x]->nombre;
                    }
                }
                $rdenunciados .= '<li>'.$den->cantidad.', '.$den->sexo.', '.$den->identidad.', '.$den->orientacion.', '.$den->nacionalidad.'</li>'; 
            }
            $item->datos_denunciados = $rdenunciados.'</ul>';
            $ta = Para_Actuacion::where('valor', $item->tipo_actuacion)->first()->nombre;
            $item->tipo_actuacion = (substr($ta, 0, 2) == '0_') ? str_replace("0_", "", $ta) : $ta;
            $item->clase_diligencia = Para_Clase_Diligencia::where('valor', $item->clase_diligencia)->first()->nombre;
            if (!is_null($item->estado_audiencia)) {
                $item->estado_audiencia = Para_Estado_Audiencia::where('valor', $item->estado_audiencia)->first()->nombre;
            }
            $item->criterio_intervencion = Para_Criterio_Intervencion::where('valor', $item->criterio_intervencion)->first()->nombre;
            $despacho = Para_Despacho::where('valor', $item->despacho_judicial)->first();
            $item->despacho_judicial = $despacho->codigo . ' -- ' . $despacho->nombre;
            $item->delito = Para_Delito::where('valor', $item->delito)->first()->nombre;
            $item->fecha_actuacion = Carbon::parse($item->fecha_actuacion)->format('d/m/Y');
            $item->observaciones = base64_decode($item->observaciones);
            if (!is_null($item->archivo_or)) {
                $item->link_archivo = '<a href="/penales2/archivo/'.$item->archivo_dt.'">'.$item->archivo_or.'</a>';
            } else{
                $item->link_archivo = '';
            }
            if ($item->eliminado == 0) {
                $item->eliminado = 'NO';
            } else {
                $item->eliminado = 'SI';
            }
            $item->cc_usuario_crea = $item->usuario_crea;
            $item->usuario_crea = Para_Usuarios::where('valor', $item->usuario_crea)->first()->nombre;
            $item->fecha_crea = Carbon::parse($item->created_at)->format('d/m/Y');
        }
        return $retorno;
    }

    public function informe_detalle3_datos(Request $request){
        $sesion = Session::get('UsuarioMp');
        $rol = $sesion[0]['rol'];
        $cedula = $sesion[0]['cedula'];

        $parametros = $request->all();
        $retorno = array();
        $obj1 = $this->ComboSexo(true);
        $obj2 = $this->ComboIdentidad(true);
        $obj3 = $this->ComboOrientacion(true);
        $obj4 = $this->ComboPaises(true);
        if ($parametros['tipo'] != 3) {
            if ($parametros['actuacion'] == 999999) {
                if ($rol == 3 || $rol == 4 || $rol == 5) {
                    $retorno = Data_Policivos::where('id_tipo_mp', $parametros['delegada'])->where('tipo_formulario', $parametros['tipo'])->where('usuario_crea', $cedula)->get();
                } else {
                    $retorno = Data_Policivos::where('id_tipo_mp', $parametros['delegada'])->where('tipo_formulario', $parametros['tipo'])->get();
                }
            } else {
                if ($rol == 3 || $rol == 4 || $rol == 5) {
                    $retorno = Data_Policivos::where('id_tipo_mp', $parametros['delegada'])->where('tipo_formulario', $parametros['tipo'])->where('tipo_actuacion', $parametros['actuacion'])->where('usuario_crea', $cedula)->get();
                } else {
                    $retorno = Data_Policivos::where('id_tipo_mp', $parametros['delegada'])->where('tipo_formulario', $parametros['tipo'])->where('tipo_actuacion', $parametros['actuacion'])->get();
                }
            }
        } else {
            if ($parametros['actuacion'] == 999999) {
                $retorno = Data_Policivos::where('id_tipo_mp', $parametros['delegada'])->whereIn('tipo_formulario', [1,2])->get();
            } else {
                $retorno = Data_Policivos::where('id_tipo_mp', $parametros['delegada'])->whereIn('tipo_formulario', [1,2])->where('tipo_actuacion', $parametros['actuacion'])->get();
            }
        }
        foreach ($retorno as $item) {
            if ($item->tipo_formulario == 1) {
                $item->tipo_formulario = 'DE OFICIO';
                $den = Data_Denunciados::where('id_tipo_mp', $parametros['delegada'])->where('id_actuacion', $item->id)->first();
                if ($parametros['delegada'] == 3) {
                    $rdenunciados = $den->primer_nombre.' '.$den->segundo_nombre.' '.$den->primer_apellido.' '.$den->segundo_apellido.';'.explode('||', $den->tipo_documento)[0].': '.$den->numero_documento;
                }
                if ($parametros['delegada'] == 4 || $parametros['delegada'] == 5) {
                    $denunciados = Data_Denunciados::where('id_tipo_mp', $parametros['delegada'])->where('id_actuacion', $item->id)->get();
                    $rdenunciados = "<ul>";
                    foreach ($denunciados as $den) {
                        for ($x=0; $x < count($obj1); $x++) { 
                            if ($obj1[$x]->valor == $den->sexo) {
                                $den->sexo = $obj1[$x]->nombre;
                            }
                        }
                        for ($x=0; $x < count($obj2); $x++) { 
                            if ($obj2[$x]->valor == $den->identidad) {
                                $den->identidad = $obj2[$x]->nombre;
                            }
                        }
                        for ($x=0; $x < count($obj3); $x++) { 
                            if ($obj3[$x]->valor == $den->orientacion) {
                                $den->orientacion = $obj3[$x]->nombre;
                            }
                        }
                        for ($x=0; $x < count($obj4); $x++) { 
                            if ($obj4[$x]->valor == $den->nacionalidad) {
                                $den->nacionalidad = $obj4[$x]->nombre;
                            }
                        }
                        $rdenunciados .= '<li>'.$den->cantidad.', '.$den->sexo.', '.$den->identidad.', '.$den->orientacion.', '.$den->nacionalidad.'</li>'; 
                    }
                    $item->datos_denunciados = $rdenunciados.'</ul>';
                }
            } elseif ($item->tipo_formulario == 2) {
                $item->tipo_formulario = 'DE PARTE';
                $rdenunciados = '';
            } else{
                $item->tipo_formulario = '';
                $rdenunciados = '';
            }
            $item->id_tipo_mp = Para_Tipo_MP::where('valor', $item->id_tipo_mp)->first()->nombre;
            if (!is_null($item->act_sinproc)) {
                $temp = str_replace("- ", "", $item->act_sinproc);
                $sp1 = explode('||', $temp);
                $sp2 = explode(';', $sp1[1]);
                $item->act_sinproc = $sp1[0].'<br>Sinproc: '.$sp2[0].'<br>Tramite: '.$sp2[1].'<br>Vigencia: '.$sp2[2];
            }
            $item->datos_denunciados = $rdenunciados;
            $ta = Para_Actuacion::where('valor', $item->tipo_actuacion)->first()->nombre;
            $item->tipo_actuacion = (substr($ta, 0, 2) == '0_') ? str_replace("0_", "", $ta) : $ta;
            $item->clase_diligencia = Para_Clase_Diligencia::where('valor', $item->clase_diligencia)->first()->nombre;
            if (!is_null($item->estado_audiencia)) {
                $item->estado_audiencia = Para_Estado_Audiencia::where('valor', $item->estado_audiencia)->first()->nombre;
            }
            if (!is_null($item->despacho_judicial)) {
                $item->despacho_judicial = Para_DespachoJ::where('valor', $item->despacho_judicial)->first()->nombre;
            }
            $item->clase = Para_Clase_Policivo::where('valor', $item->clase)->first()->nombre;
            if (!is_null($item->autoridad)) {
                $item->autoridad = Para_Autoridad_Admin::where('valor', $item->autoridad)->first()->nombre;
            }
            $item->fecha_actuacion = Carbon::parse($item->fecha_actuacion)->format('d/m/Y');
            $item->observaciones = base64_decode($item->observaciones);
            if (!is_null($item->archivo_or)) {
                $item->link_archivo = '<a href="/policivos/archivo/'.$item->archivo_dt.'">'.$item->archivo_or.'</a>';
            } else{
                $item->link_archivo = '';
            }
            if ($item->eliminado == 0) {
                $item->eliminado = 'NO';
            } else {
                $item->eliminado = 'SI';
            }
            $item->cc_usuario_crea = $item->usuario_crea;
            $item->usuario_crea = Para_Usuarios::where('valor', $item->usuario_crea)->first()->nombre;
            $item->fecha_crea = Carbon::parse($item->created_at)->format('d/m/Y');
        }
        return $retorno;
    }

    public function informe_detalle6_datos(Request $request){
        $parametros = $request->all();
        $retorno = array();
        $obj1 = $this->ComboSexo(true);
        $obj2 = $this->ComboIdentidad(true);
        $obj3 = $this->ComboOrientacion(true);
        $obj4 = $this->ComboPaises(true);
        if ($parametros['actuacion'] == "1") {
            if ($parametros['tipo'] != 3) {
                $retorno = Data_Penales_Uno::where('tipo_formulario', $parametros['tipo'])->where('estado_audiencia', '!=', 2)->get();
            } else {
                $retorno = Data_Penales_Uno::whereIn('tipo_formulario', [1,2])->where('estado_audiencia', '!=', 2)->get();
            }
            foreach ($retorno as $item) {
                if ($item->tipo_formulario == 1) {
                    $item->tipo_formulario = 'DE OFICIO';
                } elseif ($item->tipo_formulario == 2) {
                    $item->tipo_formulario = 'DE PARTE';
                } else{
                    $item->tipo_formulario = '';
                }
                if (!is_null($item->act_sinproc)) {
                    $temp = str_replace("- ", "", $item->act_sinproc);
                    $sp1 = explode('||', $temp);
                    $sp2 = explode(';', $sp1[1]);
                    $item->act_sinproc = $sp1[0].'<br>Sinproc: '.$sp2[0].'<br>Tramite: '.$sp2[1].'<br>Vigencia: '.$sp2[2];
                }
                $denunciados = Data_Denunciados::where('id_tipo_mp', 1)->where('id_actuacion', $item->id)->get();
                $rdenunciados = "<ul>";
                foreach ($denunciados as $den) {
                    for ($x=0; $x < count($obj1); $x++) { 
                        if ($obj1[$x]->valor == $den->sexo) {
                            $den->sexo = $obj1[$x]->nombre;
                        }
                    }
                    for ($x=0; $x < count($obj2); $x++) { 
                        if ($obj2[$x]->valor == $den->identidad) {
                            $den->identidad = $obj2[$x]->nombre;
                        }
                    }
                    for ($x=0; $x < count($obj3); $x++) { 
                        if ($obj3[$x]->valor == $den->orientacion) {
                            $den->orientacion = $obj3[$x]->nombre;
                        }
                    }
                    for ($x=0; $x < count($obj4); $x++) { 
                        if ($obj4[$x]->valor == $den->nacionalidad) {
                            $den->nacionalidad = $obj4[$x]->nombre;
                        }
                    }
                    $rdenunciados .= '<li>'.$den->cantidad.', '.$den->sexo.', '.$den->identidad.', '.$den->orientacion.', '.$den->nacionalidad.'</li>'; 
                }
                $item->datos_denunciados = $rdenunciados.'</ul>';
                $ta = Para_Actuacion::where('valor', $item->tipo_actuacion)->first()->nombre;
                $item->tipo_actuacion = (substr($ta, 0, 2) == '0_') ? str_replace("0_", "", $ta) : $ta;
                $item->clase_diligencia = Para_Clase_Diligencia::where('valor', $item->clase_diligencia)->first()->nombre;
                if (!is_null($item->estado_audiencia)) {
                    $item->estado_audiencia = Para_Estado_Audiencia::where('valor', $item->estado_audiencia)->first()->nombre;
                }
                $item->criterio_intervencion = Para_Criterio_Intervencion::where('valor', $item->criterio_intervencion)->first()->nombre;
                $despacho = Para_Despacho::where('valor', $item->despacho_judicial)->first();
                $item->despacho_judicial = $despacho->codigo . ' -- ' . $despacho->nombre;
                $item->delito = Para_Delito::where('valor', $item->delito)->first()->nombre;
                $item->fecha_actuacion = Carbon::parse($item->fecha_actuacion)->format('d/m/Y');
                $item->observaciones = base64_decode($item->observaciones);
                if (!is_null($item->archivo_or)) {
                    $item->link_archivo = '<a href="/penales1/archivo/'.$item->archivo_dt.'">'.$item->archivo_or.'</a>';
                } else{
                    $item->link_archivo = '';
                }
                if ($item->eliminado == 0) {
                    $item->eliminado = 'NO';
                } else {
                    $item->eliminado = 'SI';
                }
                $item->cc_usuario_crea = $item->usuario_crea;
                $item->usuario_crea = Para_Usuarios::where('valor', $item->usuario_crea)->first()->nombre;
                $item->fecha_crea = Carbon::parse($item->created_at)->format('d/m/Y');
            }
        }
        if ($parametros['actuacion'] == "2") {
            if ($parametros['tipo'] != 3) {
                $retorno = Data_Penales_Dos::where('tipo_formulario', $parametros['tipo'])->where('estado_audiencia', '!=', 2)->get();
            } else {
                $retorno = Data_Penales_Dos::whereIn('tipo_formulario', [1,2])->where('estado_audiencia', '!=', 2)->get();
            }
            foreach ($retorno as $item) {
                if ($item->tipo_formulario == 1) {
                    $item->tipo_formulario = 'DE OFICIO';
                } elseif ($item->tipo_formulario == 2) {
                    $item->tipo_formulario = 'DE PARTE';
                } else{
                    $item->tipo_formulario = '';
                }
                if (!is_null($item->act_sinproc)) {
                    $temp = str_replace("- ", "", $item->act_sinproc);
                    $sp1 = explode('||', $temp);
                    $sp2 = explode(';', $sp1[1]);
                    $item->act_sinproc = $sp1[0].'<br>Sinproc: '.$sp2[0].'<br>Tramite: '.$sp2[1].'<br>Vigencia: '.$sp2[2];
                }
                $denunciados = Data_Denunciados::where('id_tipo_mp', 1)->where('id_actuacion', $item->id)->get();
                $rdenunciados = "<ul>";
                foreach ($denunciados as $den) {
                    for ($x=0; $x < count($obj1); $x++) { 
                        if ($obj1[$x]->valor == $den->sexo) {
                            $den->sexo = $obj1[$x]->nombre;
                        }
                    }
                    for ($x=0; $x < count($obj2); $x++) { 
                        if ($obj2[$x]->valor == $den->identidad) {
                            $den->identidad = $obj2[$x]->nombre;
                        }
                    }
                    for ($x=0; $x < count($obj3); $x++) { 
                        if ($obj3[$x]->valor == $den->orientacion) {
                            $den->orientacion = $obj3[$x]->nombre;
                        }
                    }
                    for ($x=0; $x < count($obj4); $x++) { 
                        if ($obj4[$x]->valor == $den->nacionalidad) {
                            $den->nacionalidad = $obj4[$x]->nombre;
                        }
                    }
                    $rdenunciados .= '<li>'.$den->cantidad.', '.$den->sexo.', '.$den->identidad.', '.$den->orientacion.', '.$den->nacionalidad.'</li>'; 
                }
                $item->datos_denunciados = $rdenunciados.'</ul>';
                $ta = Para_Actuacion::where('valor', $item->tipo_actuacion)->first()->nombre;
                $item->tipo_actuacion = (substr($ta, 0, 2) == '0_') ? str_replace("0_", "", $ta) : $ta;
                $item->clase_diligencia = Para_Clase_Diligencia::where('valor', $item->clase_diligencia)->first()->nombre;
                if (!is_null($item->estado_audiencia)) {
                    $item->estado_audiencia = Para_Estado_Audiencia::where('valor', $item->estado_audiencia)->first()->nombre;
                }
                $item->criterio_intervencion = Para_Criterio_Intervencion::where('valor', $item->criterio_intervencion)->first()->nombre;
                $despacho = Para_Despacho::where('valor', $item->despacho_judicial)->first();
                $item->despacho_judicial = $despacho->codigo . ' -- ' . $despacho->nombre;
                $item->delito = Para_Delito::where('valor', $item->delito)->first()->nombre;
                $item->fecha_actuacion = Carbon::parse($item->fecha_actuacion)->format('d/m/Y');
                $item->observaciones = base64_decode($item->observaciones);
                if (!is_null($item->archivo_or)) {
                    $item->link_archivo = '<a href="/penales1/archivo/'.$item->archivo_dt.'">'.$item->archivo_or.'</a>';
                } else{
                    $item->link_archivo = '';
                }
                if ($item->eliminado == 0) {
                    $item->eliminado = 'NO';
                } else {
                    $item->eliminado = 'SI';
                }
                $item->cc_usuario_crea = $item->usuario_crea;
                $item->usuario_crea = Para_Usuarios::where('valor', $item->usuario_crea)->first()->nombre;
                $item->fecha_crea = Carbon::parse($item->created_at)->format('d/m/Y');
            }
        }
        if ($parametros['actuacion'] == "3" || $parametros['actuacion'] == "4" || $parametros['actuacion'] == "5") {
            if ($parametros['tipo'] != 3) {
                $retorno = Data_Policivos::where('id_tipo_mp', $parametros['actuacion'])->where('tipo_formulario', $parametros['tipo'])->get();
            } else {
                $retorno = Data_Policivos::where('id_tipo_mp', $parametros['actuacion'])->whereIn('tipo_formulario', [1,2])->get();
            }
            foreach ($retorno as $item) {
                if ($item->tipo_formulario == 1) {
                    $item->tipo_formulario = 'DE OFICIO';
                    $den = Data_Denunciados::where('id_tipo_mp', $parametros['actuacion'])->where('id_actuacion', $item->id)->first();
                    if ($parametros['actuacion'] == 3) {
                        $rdenunciados = $den->primer_nombre.' '.$den->segundo_nombre.' '.$den->primer_apellido.' '.$den->segundo_apellido.', '.explode('||', $den->tipo_documento)[0].': '.$den->numero_documento;
                    }
                    if ($parametros['actuacion'] == 4 || $parametros['actuacion'] == 5) {
                        $denunciados = Data_Denunciados::where('id_tipo_mp', $parametros['actuacion'])->where('id_actuacion', $item->id)->get();
                        $rdenunciados = "<ul>";
                        foreach ($denunciados as $den) {
                            for ($x=0; $x < count($obj1); $x++) { 
                                if ($obj1[$x]->valor == $den->sexo) {
                                    $den->sexo = $obj1[$x]->nombre;
                                }
                            }
                            for ($x=0; $x < count($obj2); $x++) { 
                                if ($obj2[$x]->valor == $den->identidad) {
                                    $den->identidad = $obj2[$x]->nombre;
                                }
                            }
                            for ($x=0; $x < count($obj3); $x++) { 
                                if ($obj3[$x]->valor == $den->orientacion) {
                                    $den->orientacion = $obj3[$x]->nombre;
                                }
                            }
                            for ($x=0; $x < count($obj4); $x++) { 
                                if ($obj4[$x]->valor == $den->nacionalidad) {
                                    $den->nacionalidad = $obj4[$x]->nombre;
                                }
                            }
                            $rdenunciados .= '<li>'.$den->cantidad.', '.$den->sexo.', '.$den->identidad.', '.$den->orientacion.', '.$den->nacionalidad.'</li>'; 
                        }
                        $item->datos_denunciados = $rdenunciados.'</ul>';
                    }
                } elseif ($item->tipo_formulario == 2) {
                    $item->tipo_formulario = 'DE PARTE';
                    $rdenunciados = '';
                } else{
                    $item->tipo_formulario = '';
                    $rdenunciados = '';
                }
                $item->id_tipo_mp = Para_Tipo_MP::where('valor', $item->id_tipo_mp)->first()->nombre;
                if (!is_null($item->act_sinproc)) {
                    $temp = str_replace("- ", "", $item->act_sinproc);
                    $sp1 = explode('||', $temp);
                    $sp2 = explode(';', $sp1[1]);
                    $item->act_sinproc = $sp1[0].'<br>Sinproc: '.$sp2[0].'<br>Tramite: '.$sp2[1].'<br>Vigencia: '.$sp2[2];
                }
                $item->datos_denunciados = $rdenunciados;
                $ta = Para_Actuacion::where('valor', $item->tipo_actuacion)->first()->nombre;
                $item->tipo_actuacion = (substr($ta, 0, 2) == '0_') ? str_replace("0_", "", $ta) : $ta;
                $item->clase_diligencia = Para_Clase_Diligencia::where('valor', $item->clase_diligencia)->first()->nombre;
                if (!is_null($item->estado_audiencia)) {
                    $item->estado_audiencia = Para_Estado_Audiencia::where('valor', $item->estado_audiencia)->first()->nombre;
                }
                if (!is_null($item->despacho_judicial)) {
                    $item->despacho_judicial = Para_DespachoJ::where('valor', $item->despacho_judicial)->first()->nombre;
                }
                $item->clase = Para_Clase_Policivo::where('valor', $item->clase)->first()->nombre;
                if (!is_null($item->autoridad)) {
                    $item->autoridad = Para_Autoridad_Admin::where('valor', $item->autoridad)->first()->nombre;
                }
                $item->fecha_actuacion = Carbon::parse($item->fecha_actuacion)->format('d/m/Y');
                $item->observaciones = base64_decode($item->observaciones);
                if (!is_null($item->archivo_or)) {
                    $item->link_archivo = '<a href="/policivos/archivo/'.$item->archivo_dt.'">'.$item->archivo_or.'</a>';
                } else{
                    $item->link_archivo = '';
                }
                if ($item->eliminado == 0) {
                    $item->eliminado = 'NO';
                } else {
                    $item->eliminado = 'SI';
                }
                $item->cc_usuario_crea = $item->usuario_crea;
                $item->usuario_crea = Para_Usuarios::where('valor', $item->usuario_crea)->first()->nombre;
                $item->fecha_crea = Carbon::parse($item->created_at)->format('d/m/Y');
            }
        }
        return $retorno;
    }

    public function informe_detalle7_datos(Request $request){
        $sesion = Session::get('UsuarioMp');
        $rol = $sesion[0]['rol'];
        $cedula = $sesion[0]['cedula'];

        $parametros = $request->all();
        $sp = explode('_', $parametros['actuacion']);
        $agencias = array();
        if ($sp[1] == 'PENALES1') {
            if ($parametros['tipo'] == 1) {
                $agencias = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 1)->where('estado', '!=', 4)->get();
            } elseif ($parametros['tipo'] == 2) {
                $agencias = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 1)->where('estado', 4)->get();
            } else{
                $agencias = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 1)->get();
            }
        } elseif ($sp[1] == 'PENALES2') {
            if ($parametros['tipo'] == 1) {
                $agencias = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 2)->where('estado', '!=', 4)->get();
            } elseif ($parametros['tipo'] == 2) {
                $agencias = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 2)->where('estado', 4)->get();
            } else{
                $agencias = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 2)->get();
            }
        } else{
            if ($parametros['tipo'] == 1) {
                $agencias = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 1)->get();
            } elseif ($parametros['tipo'] == 2) {
                $agencias = Data_Agencia_Especial::where('eliminado', false)->where('delegada', 2)->get();
            } else{
                $agencias = Data_Agencia_Especial::where('eliminado', false)->get();
            }
        }
        foreach ($agencias as $item) {
            $obj1 = $this->ComboSexo(true);
            $obj2 = $this->ComboIdentidad(true);
            $obj3 = $this->ComboOrientacion(true);
            $obj4 = $this->ComboPaises(true);
            $u_informe = Data_Agencia_Informe::where('id_agencia_especial', $item->id)->orderBy('id_periodo_reportado', 'desc')->first();
            $informes = Data_Agencia_Informe::where('id_agencia_especial', $item->id)->orderBy('id_periodo_reportado', 'asc')->get();
            $victimas = Data_Denunciados::where('id_actuacion', $item->id)->where('id_tipo_mp', 99)->get();
            $item->numero_agencia_especial = sprintf("%03d", $item->numero_agencia_especial);
            $item->fecha_creacion = Carbon::parse($item->fecha_creacion)->format('d/m/Y');
            $item->delegada = Para_Delegada::where('valor', $item->delegada)->first()->nombre;
            $item->nombre_ministerio = Para_Usuarios::where('valor', $item->nombre_ministerio)->first()->nombre;
            $item->tipo_victima = Para_Tipo_Victima::where('valor', $u_informe['tipo_victima'])->first()['nombre'];
            $despacho = Para_Despacho::where('valor', $item->despacho_judicial)->first();
            $item->despacho_judicial = $despacho->codigo . ' -- ' . $despacho->nombre;
            $corr_delito = "";
            $corr_despacho = "";
            $indiciado = "<ul>";
            $actuacion_procesal = "<ul>";
            foreach ($informes as $inf) {
                if ($inf->corregir_delito == 'Si') {
                    $corr_delito = Para_Delito::where('valor', $inf->nuevo_delito)->first()->nombre;
                    $despacho = Para_Despacho::where('valor', $inf->nuevo_despacho)->first();
                    $corr_despacho = $despacho->codigo . ' -- ' . $despacho->nombre;
                }
                if ($inf->dato_indiciado == 'Si') {
                    $indiciado .= '<li>'.$inf->indentificacion_indiciado.': '.$inf->nombre_indiciado.'</li>'; 
                }
                $actuacion_procesal .= '<li>'.base64_decode($inf->actuacion_procesal).'</li><xsl:text>&#xA;</xsl:text><xsl:text>&#xA;</xsl:text>';
            }
            $indiciado .= "</ul>";
            $actuacion_procesal .= "</ul>";
            $item->corr_delito = $corr_delito;
            $item->corr_despacho = $corr_despacho;
            $item->indiciado = $indiciado;
            $l_victimas = "<ul>";
            foreach ($victimas as $den) {
                for ($x=0; $x < count($obj1); $x++) { 
                    if ($obj1[$x]->valor == $den->sexo) {
                        $den->sexo = $obj1[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj2); $x++) { 
                    if ($obj2[$x]->valor == $den->identidad) {
                        $den->identidad = $obj2[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj3); $x++) { 
                    if ($obj3[$x]->valor == $den->orientacion) {
                        $den->orientacion = $obj3[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj4); $x++) { 
                    if ($obj4[$x]->valor == $den->nacionalidad) {
                        $den->nacionalidad = $obj4[$x]->nombre;
                    }
                }
                $l_victimas .= '<li>'.$den->primer_nombre.' '.$den->primer_apellido.', '.$den->sexo.', '.$den->identidad.', '.$den->orientacion.', '.$den->nacionalidad.'</li>'; 
            }
            $l_victimas .= "</ul>";
            $item->victimas = $l_victimas;
            $item->adecuacion_tipica = Para_Delito::where('valor', $item->adecuacion_tipica)->first()->nombre;
            $item->criterio_creacion = Para_Criterio_Creacion::where('valor', $item->criterio_creacion)->first()->nombre;
            $item->justificacion = base64_decode($item->justificacion);
            $item->sintesis = base64_decode($item->sintesis);
            $item->actuacion_procesal = $actuacion_procesal;
            $item->estado = ($item->estado == 4) ? 'FINALIZADA' : 'ABIERTA';
            $temp = base64_decode($item->justificacion_fin);
            $sp1 = explode('||', $temp);
            $html = '';
            for ($i=1; $i < count($sp1); $i++) { 
                $sp2 = explode('((', $sp1[$i]);
                $html .= '<strong>'.$sp2[0].'</strong><br><xsl:text>&#xA;</xsl:text>'.$sp2[1].'<br><br><xsl:text>&#xA;</xsl:text><xsl:text>&#xA;</xsl:text>';
            }
            $item->justificacion_fin = $html;
            $item->eliminado = ($item->eliminado == 0) ? 'NO' : 'SI';
            $item->cc_usuario_crea = $item->usuario_crea;
            $item->usuario_crea = Para_Usuarios::where('valor', $item->usuario_crea)->first()->nombre;
        }
        return $agencias;
    }

}
