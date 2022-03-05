<?php

namespace App\Http\Controllers;
date_default_timezone_set('America/Bogota');

use App\Models\Data_Denunciados;
use App\Models\Data_Enteramiento;
use App\Models\Data_Policivos;
use App\Models\Para_Actuacion;
use App\Models\Para_Autoridad_Admin;
use App\Models\Para_Clase_Diligencia;
use App\Models\Para_Clase_Policivo;
use App\Models\Para_DespachoJ;
use App\Models\Para_Estado_Audiencia;
use App\Models\Para_Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class MPPolicivosController extends Controller
{
    public static function estoy_logeado(){
        if (Session::has('UsuarioMp')){
            return true;
        } else{
            return false;
        }
    }

    //=================================Movilidad De Oficio =================================
        public function movilidad_oficio(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('policivos.movilidad.oficio', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function movilidad_oficio_actuaciones(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Policivos::where('eliminado', false)->where('tipo_formulario', 1)->where('id_tipo_mp', 3)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $retorno[$i]['txt_tipo_actuacion'] = Para_Actuacion::where('valor', $retorno[$i]['tipo_actuacion'])->first()->nombre;
                $retorno[$i]['txt_clase_diligencia'] = Para_Clase_Diligencia::where('valor', $retorno[$i]['clase_diligencia'])->first()->nombre;
                $retorno[$i]['txt_estado_audiencia'] = ($retorno[$i]['estado_audiencia'] === null) ? "":Para_Estado_Audiencia::where('valor', $retorno[$i]['estado_audiencia'])->first()->nombre;
                $retorno[$i]['txt_clase'] = Para_Clase_Policivo::where('valor', $retorno[$i]['clase'])->first()->nombre;
                $retorno[$i]['btn_acciones'] = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ');"><i class="far fa-eye"></i></button>';
            }
            return $retorno;
        }

        public function movilidad_oficio_modal(Request $request){
            $parametricas['actuacion'] = $this->GenerarSelect(Para_Actuacion::where('eliminado', false)->whereIn('id_tipo_mp', [3])->orderBy('nombre', 'asc')->get());
            $parametricas['contravencion'] = $this->GenerarSelect(Para_Clase_Policivo::where('id_tipo_mp', 3)->where('eliminado', false)->get());
            return view('policivos.movilidad.oficio_crear', compact('parametricas'));
        }

        public function movilidad_cambio_tipo_actuacion(Request $request){
            $parametros = $request->all();
            $clase_diligencia = Para_Clase_Diligencia::where('eliminado', false)->where('id_actuacion', $parametros['ta'])->get();
            $estado_audiencia = Para_Estado_Audiencia::where('eliminado', false)->whereIn('id_tipo_mp', [3])->get();
            $retorno = array('clase_diligencia' => $this->GenerarSelect($clase_diligencia), 'estado_audiencia' => $this->GenerarSelect($estado_audiencia));
            return $retorno;
        }

        public function movilidad_oficio_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['tipo_formulario'] = 1;
            $campos['id_tipo_mp'] = 3;
            $sp = explode('/', $campos['fecha_actuacion']);
            $campos['fecha_actuacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'policivos';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Policivos::create($campos)->id;
            $arr = array(
                'id_tipo_mp' => 3, 
                'id_actuacion' => $idP1, 
                'primer_nombre' => $campos['primer_nombre'],
                'segundo_nombre' => $campos['segundo_nombre'],
                'primer_apellido' => $campos['primer_apellido'],
                'segundo_apellido' => $campos['segundo_apellido'],
                'tipo_documento' => $campos['tipo_documento'],
                'numero_documento' => $campos['numero_documento'],
                'usuario_crea' => $cc
            );
            Data_Denunciados::create($arr);
            return redirect('movilidad/oficio')->with('success', 'Registro de Policivos / Movilidad (Oficio) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function movilidad_oficio_modal_ver(Request $request){
            $consulta = $request->all();
            $campos = Data_Policivos::where('id', $consulta['id'])->first();
            $campos->tipo_actuacion = Para_Actuacion::where('valor', $campos->tipo_actuacion)->first()->nombre;
            $campos->clase_diligencia = Para_Clase_Diligencia::where('valor', $campos->clase_diligencia)->first()->nombre;
            if (!is_null($campos->estado_audiencia)) {
                $campos->estado_audiencia = Para_Estado_Audiencia::where('valor', $campos->estado_audiencia)->first()->nombre;
            }
            $campos->clase = Para_Clase_Policivo::where('valor', $campos->clase)->first()->nombre;
            $campos->observaciones = base64_decode($campos->observaciones);
            $campos->fecha_actuacion = Carbon::parse($campos->fecha_actuacion)->format('d/m/Y');
            $denunciados = Data_Denunciados::where('id_tipo_mp', 3)->where('id_actuacion', $consulta['id'])->first();
            $denunciados->tipo_documento = explode('||', $denunciados->tipo_documento)[1];
            return view('policivos.movilidad.oficio_ver', compact('campos', 'denunciados'));
        }

        public function policivos_archivo($archivo){
            $archivo_or = Data_Policivos::where('archivo_dt', $archivo)->first()->archivo_or;
            $ptArchivo = storage_path(). '/policivos/' . $archivo;
            return response()->download($ptArchivo, $archivo_or);
        }

    //=================================Movilidad De Parte =================================
        public function movilidad_parte(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('policivos.movilidad.parte', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function movilidad_parte_actuaciones(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Policivos::where('eliminado', false)->where('tipo_formulario', 2)->where('id_tipo_mp', 3)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $retorno[$i]['txt_tipo_actuacion'] = Para_Actuacion::where('valor', $retorno[$i]['tipo_actuacion'])->first()->nombre;
                $retorno[$i]['txt_clase_diligencia'] = Para_Clase_Diligencia::where('valor', $retorno[$i]['clase_diligencia'])->first()->nombre;
                $retorno[$i]['txt_estado_audiencia'] = ( $retorno[$i]['estado_audiencia'] === null) ? "":Para_Estado_Audiencia::where('valor', $retorno[$i]['estado_audiencia'])->first()->nombre;
                $retorno[$i]['txt_clase'] = Para_Clase_Policivo::where('valor', $retorno[$i]['clase'])->first()->nombre;
                $sp = explode('||', $retorno[$i]['act_sinproc']);
                $btnVer = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ');" data-toggle="tooltip" data-html="true" title="<b><u>Ver Intervención</u></b>"><i class="fas fa-eye"></i></button>';
                $btnAct = '<button type="button" class="btn btn-primary" onclick="Act(' . $retorno[$i]['id'] . ", '" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Registrar Actuación</u></b>"><i class="fas fa-chalkboard-teacher"></i></button>';
                $btnRem = '<button type="button" class="btn btn-primary" onclick="Rem(' . "'" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Remitir Proceso</u></b>"><i class="fas fa-file-import"></i></button>';
                $btnArc = '<button type="button" class="btn btn-primary" onclick="Arc(' . "'" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Archivar Procesos</u></b>"><i class="fas fa-door-closed"></i></button>';
                if ($this->ChecarSinproc($cedula, $retorno[$i]['sinproc'])) {
                    $cont = Data_Policivos::where('eliminado', false)->where('sinproc', $retorno[$i]['sinproc'])->where('habilitar_archivo', true)->count();
                    if ($cont > 0) {
                        $retorno[$i]['btn_acciones'] = $btnVer.' '.$btnAct.' '.$btnRem.' '.$btnArc;
                    } else{
                        $retorno[$i]['btn_acciones'] = $btnVer.' '.$btnAct.' '.$btnRem;
                    }
                } else {
                    $retorno[$i]['btn_acciones'] = $btnVer;
                }
                $fecha_intervencion = Carbon::parse($retorno[$i]['fecha_actuacion'])->format('d/m/Y');
                $observaciones = base64_decode($retorno[$i]['observaciones']);
                $retorno[$i]['txt_actuacion_sinproc'] = "TIPO DE INTERVENCIÓN: ".$retorno[$i]['txt_tipo_actuacion']."\nCLASE DE DILIGENCIA: ".$retorno[$i]['txt_clase_diligencia']."\nCLASE DE CONTRAVENCIÓN: ".$retorno[$i]['txt_clase']."\nFECHA DE INTERVENCIÓN: ".$fecha_intervencion."\nNO DE EXPEDIENTE: ".$retorno[$i]['numero']."\nOBSERVACIONES: ".$observaciones;
            }
            return $retorno;
        }

        public function movilidad_parte_modal(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $parametricas['actuacion'] = $this->GenerarSelect(Para_Actuacion::where('eliminado', false)->whereIn('id_tipo_mp', [3])->orderBy('nombre', 'asc')->get());
            $parametricas['contravencion'] = $this->GenerarSelect(Para_Clase_Policivo::where('id_tipo_mp', 3)->where('eliminado', false)->get());
            $sinprocs = $this->Sinprocs($cedula);
            return view('policivos.movilidad.parte_crear', compact('parametricas', 'sinprocs'));
        }

        public function movilidad_parte_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['tipo_formulario'] = 2;
            $campos['id_tipo_mp'] = 3;
            $sp = explode('/', $campos['fecha_actuacion']);
            $campos['fecha_actuacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'policivos';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Policivos::create($campos)->id;
            return redirect('movilidad/parte')->with('success', 'Registro de Policivos / Movilidad (Parte) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function movilidad_parte_modal_ver(Request $request){
            $consulta = $request->all();
            $campos = Data_Policivos::where('id', $consulta['id'])->first();
            $campos->tipo_actuacion = Para_Actuacion::where('valor', $campos->tipo_actuacion)->first()->nombre;
            $campos->clase_diligencia = Para_Clase_Diligencia::where('valor', $campos->clase_diligencia)->first()->nombre;
            if (!is_null($campos->estado_audiencia)) {
                $campos->estado_audiencia = Para_Estado_Audiencia::where('valor', $campos->estado_audiencia)->first()->nombre;
            }
            $campos->clase = Para_Clase_Policivo::where('valor', $campos->clase)->first()->nombre;
            $campos->observaciones = base64_decode($campos->observaciones);
            $campos->fecha_actuacion = Carbon::parse($campos->fecha_actuacion)->format('d/m/Y');
            $sp = explode('||', $campos->act_sinproc);
            $spd = explode(';', $sp[1]);
            $datos_sinproc = $this->DetalleSinproc($spd, true);
            return view('policivos.movilidad.parte_ver', compact('campos', 'datos_sinproc'));
        }

        public function parte_guardar_act_sinproc(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $parametros = $request->all();
            $id = Data_Policivos::where('eliminado', false)->where('sinproc', $parametros['sinproc'])->first()->id;
            $arr = array(
                'habilitar_archivo' => true,
                'usuario_modifica' => $cc
            );
            Data_Policivos::find($id)->update($arr);
            return 'true';
        }

    //=================================Movilidad Notificaciones =================================
        public function movilidad_notificaciones(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('policivos.movilidad.enteramientos', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function movilidad_notificaciones_listas(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Enteramiento::where('eliminado', false)->where('id_tipo_mp', 3)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $retorno[$i]['txt_unidad'] = Para_Unidad::where('valor', $retorno[$i]['unidad'])->first()->nombre;
                $retorno[$i]['fechaCrea'] = Carbon::parse($retorno[$i]['created_at'])->format('d/m/Y');
                if ($retorno[$i]['archivo_dt'] != '') {
                    $retorno[$i]['btn_acciones'] = '<a  href="/policivos/archivo_notificaciones/'.$retorno[$i]['archivo_dt'].'" class="btn btn-primary"><i class="fas fa-paperclip"></i></a>';
                } else {
                    $retorno[$i]['btn_acciones'] = '';
                }
                
                
            }
            return $retorno;
        }

        public function movilidad_notificaciones_modal(Request $request){
            $parametricas['unidad'] = $this->GenerarSelect(Para_Unidad::where('eliminado', false)->where('id_tipo_mp', 3)->get());
            return view('policivos.movilidad.enteramientos_crear', compact('parametricas'));
        }

        public function movilidad_notificaciones_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['id_tipo_mp'] = 3;
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'policivos';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Enteramiento::create($campos)->id;
            return redirect('movilidad/notificaciones')->with('success', 'Registro de Movilidad (Notificaciones) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function policivos_archivo_notificaciones($archivo){
            $archivo_or = Data_Enteramiento::where('archivo_dt', $archivo)->first()->archivo_or;
            $ptArchivo = storage_path(). '/policivos/' . $archivo;
            return response()->download($ptArchivo, $archivo_or);
        }

    //=================================Juzgados De Oficio =================================
        public function juzgados_oficio(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('policivos.juzgados.oficio', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function juzgados_oficio_actuaciones(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Policivos::where('eliminado', false)->where('tipo_formulario', 1)->where('id_tipo_mp', 4)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $temp = Para_Actuacion::where('valor', $retorno[$i]['tipo_actuacion'])->first()->nombre;
                $retorno[$i]['txt_tipo_actuacion'] = (substr($temp, 0, 2) == '0_') ? str_replace("0_", "", $temp) : $temp;
                $retorno[$i]['txt_clase_diligencia'] = Para_Clase_Diligencia::where('valor', $retorno[$i]['clase_diligencia'])->first()->nombre;
                $retorno[$i]['txt_estado_audiencia'] = ( $retorno[$i]['estado_audiencia'] === null) ? "":Para_Estado_Audiencia::where('valor', $retorno[$i]['estado_audiencia'])->first()->nombre;
                $retorno[$i]['txt_clase'] = Para_Clase_Policivo::where('valor', $retorno[$i]['clase'])->first()->nombre;
                $retorno[$i]['btn_acciones'] = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ');"><i class="far fa-eye"></i></button>';
            }
            return $retorno;
        }

        public function juzgados_oficio_modal(Request $request){
            $parametricas['actuacion'] = $this->GenerarSelect(Para_Actuacion::where('eliminado', false)->whereIn('id_tipo_mp', [4])->orderBy('nombre', 'asc')->get());
            $parametricas['proceso'] = $this->GenerarSelect(Para_Clase_Policivo::where('id_tipo_mp', 4)->where('eliminado', false)->get());
            $parametricas['despachoj'] = $this->GenerarSelect(Para_DespachoJ::where('eliminado', false)->get());
            $parametricas['sexo'] = $this->ComboSexo();
            $parametricas['identidad'] = $this->ComboIdentidad();
            $parametricas['orientacion'] = $this->ComboOrientacion();
            $parametricas['nacionalidad'] = $this->ComboPaises();
            return view('policivos.juzgados.oficio_crear', compact('parametricas'));
        }

        public function juzgados_cambio_tipo_actuacion(Request $request){
            $parametros = $request->all();
            $clase_diligencia = Para_Clase_Diligencia::where('eliminado', false)->where('id_actuacion', $parametros['ta'])->get();
            $retorno = array('clase_diligencia' => $this->GenerarSelect($clase_diligencia));
            return $retorno;
        }

        public function juzgados_oficio_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['tipo_formulario'] = 1;
            $campos['id_tipo_mp'] = 4;
            $sp = explode('/', $campos['fecha_actuacion']);
            $campos['fecha_actuacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'policivos';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Policivos::create($campos)->id;
            if ($campos['identifica_denunciado'] == 'Si') {
                for ($i=1; $i <= $campos['clicksMas']; $i++) { 
                    $arr = array(
                        'id_tipo_mp' => 4, 
                        'id_actuacion' => $idP1, 
                        'cantidad' => $campos['cantidad_' . $i],
                        'sexo' => $campos['sexo_' . $i],
                        'identidad' => $campos['identidad_' . $i],
                        'orientacion' => $campos['orientacion_' . $i],
                        'nacionalidad' => $campos['nacionalidad_' . $i],
                        'usuario_crea' => $cc
                    );
                    Data_Denunciados::create($arr);
                }
            }
            return redirect('juzgados/oficio')->with('success', 'Registro de Policivos / Juzgados (Oficio) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function juzgados_oficio_modal_ver(Request $request){
            $consulta = $request->all();
            $campos = Data_Policivos::where('id', $consulta['id'])->first();
            $campos->tipo_actuacion = Para_Actuacion::where('valor', $campos->tipo_actuacion)->first()->nombre;
            $campos->clase_diligencia = Para_Clase_Diligencia::where('valor', $campos->clase_diligencia)->first()->nombre;
            $campos->despacho_judicial = Para_DespachoJ::where('valor', $campos->despacho_judicial)->first()->nombre;
            $campos->clase = Para_Clase_Policivo::where('valor', $campos->clase)->first()->nombre;
            $campos->observaciones = base64_decode($campos->observaciones);
            $campos->fecha_actuacion = Carbon::parse($campos->fecha_actuacion)->format('d/m/Y');
            $denunciados = Data_Denunciados::where('id_tipo_mp', 4)->where('id_actuacion', $consulta['id'])->get();
            $obj1 = $this->ComboSexo(true);
            $obj2 = $this->ComboIdentidad(true);
            $obj3 = $this->ComboOrientacion(true);
            $obj4 = $this->ComboPaises(true);
            $rdenunciados = "";
            for ($i=0; $i < count($denunciados); $i++) { 
                for ($x=0; $x < count($obj1); $x++) { 
                    if ($obj1[$x]->valor == $denunciados[$i]['sexo']) {
                        $denunciados[$i]['sexo'] = $obj1[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj2); $x++) { 
                    if ($obj2[$x]->valor == $denunciados[$i]['identidad']) {
                        $denunciados[$i]['identidad'] = $obj2[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj3); $x++) { 
                    if ($obj3[$x]->valor == $denunciados[$i]['orientacion']) {
                        $denunciados[$i]['orientacion'] = $obj3[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj4); $x++) { 
                    if ($obj4[$x]->valor == $denunciados[$i]['nacionalidad']) {
                        $denunciados[$i]['nacionalidad'] = $obj4[$x]->nombre;
                    }
                }
                $rdenunciados .= '<div class="row lineaD" style="margin: 20px 0px 10px 0px;"><div class="col-md-4"><label class="minilabel">Sexo</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['sexo'];
                $rdenunciados .= '" disabled></div><div class="col-md-4"><label class="minilabel">Identidad</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['identidad'];
                $rdenunciados .= '" disabled></div><div class="col-md-4"><label class="minilabel">Orientacion</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['orientacion'];
                $rdenunciados .= '" disabled></div><div class="col-md-4" style="padding-top: 20px;"><label class="minilabel">Cantidad</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['cantidad'];
                $rdenunciados .= '" disabled></div><div class="col-md-8" style="padding-top: 20px;"><label class="minilabel">Nacionalidad</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['nacionalidad'];
                $rdenunciados .= '" disabled></div></div>';
            }
            return view('policivos.juzgados.oficio_ver', compact('campos', 'rdenunciados'));
        }

    //=================================Juzgados De Parte =================================
        public function juzgados_parte(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('policivos.juzgados.parte', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function juzgados_parte_actuaciones(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Policivos::where('eliminado', false)->where('tipo_formulario', 2)->where('id_tipo_mp', 4)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $temp = Para_Actuacion::where('valor', $retorno[$i]['tipo_actuacion'])->first()->nombre;
                $retorno[$i]['txt_tipo_actuacion'] = (substr($temp, 0, 2) == '0_') ? str_replace("0_", "", $temp) : $temp;
                $retorno[$i]['txt_clase_diligencia'] = Para_Clase_Diligencia::where('valor', $retorno[$i]['clase_diligencia'])->first()->nombre;
                $retorno[$i]['txt_estado_audiencia'] = ( $retorno[$i]['estado_audiencia'] === null) ? "":Para_Estado_Audiencia::where('valor', $retorno[$i]['estado_audiencia'])->first()->nombre;
                $retorno[$i]['txt_clase'] = Para_Clase_Policivo::where('valor', $retorno[$i]['clase'])->first()->nombre;
                $sp = explode('||', $retorno[$i]['act_sinproc']);
                $btnVer = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ');" data-toggle="tooltip" data-html="true" title="<b><u>Ver Intervención</u></b>"><i class="fas fa-eye"></i></button>';
                $btnAct = '<button type="button" class="btn btn-primary" onclick="Act(' . $retorno[$i]['id'] . ", '" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Registrar Actuación</u></b>"><i class="fas fa-chalkboard-teacher"></i></button>';
                $btnRem = '<button type="button" class="btn btn-primary" onclick="Rem(' . "'" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Remitir Proceso</u></b>"><i class="fas fa-file-import"></i></button>';
                $btnArc = '<button type="button" class="btn btn-primary" onclick="Arc(' . "'" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Archivar Procesos</u></b>"><i class="fas fa-door-closed"></i></button>';
                if ($this->ChecarSinproc($cedula, $retorno[$i]['sinproc'])) {
                    $cont = Data_Policivos::where('eliminado', false)->where('sinproc', $retorno[$i]['sinproc'])->where('habilitar_archivo', true)->count();
                    if ($cont > 0) {
                        $retorno[$i]['btn_acciones'] = $btnVer.' '.$btnAct.' '.$btnRem.' '.$btnArc;
                    } else{
                        $retorno[$i]['btn_acciones'] = $btnVer.' '.$btnAct.' '.$btnRem;
                    }
                } else {
                    $retorno[$i]['btn_acciones'] = $btnVer;
                }
                $despacho = Para_DespachoJ::where('valor', $retorno[$i]['despacho_judicial'])->first()->nombre;
                $fecha_intervencion = Carbon::parse($retorno[$i]['fecha_actuacion'])->format('d/m/Y');
                $observaciones = base64_decode($retorno[$i]['observaciones']);
                $retorno[$i]['txt_actuacion_sinproc'] = "TIPO DE INTERVENCIÓN: ".$retorno[$i]['txt_tipo_actuacion']."\nCLASE DE DILIGENCIA: ".$retorno[$i]['txt_clase_diligencia']."\nDESPACHO JUDICIAL: ".$despacho."\nCLASE DE PROCESO: ".$retorno[$i]['txt_clase']."\nFECHA DE INTERVENCIÓN: ".$fecha_intervencion."\nNO DE PROCESO: ".$retorno[$i]['numero']."\nOBSERVACIONES: ".$observaciones;
            }
            return $retorno;
        }

        public function juzgados_parte_modal(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $parametricas['actuacion'] = $this->GenerarSelect(Para_Actuacion::where('eliminado', false)->whereIn('id_tipo_mp', [4])->orderBy('nombre', 'asc')->get());
            $parametricas['proceso'] = $this->GenerarSelect(Para_Clase_Policivo::where('id_tipo_mp', 4)->where('eliminado', false)->get());
            $parametricas['despachoj'] = $this->GenerarSelect(Para_DespachoJ::where('eliminado', false)->get());
            $sinprocs = $this->Sinprocs($cedula);
            return view('policivos.juzgados.parte_crear', compact('parametricas', 'sinprocs'));
        }

        public function juzgados_parte_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['tipo_formulario'] = 2;
            $campos['id_tipo_mp'] = 4;
            $sp = explode('/', $campos['fecha_actuacion']);
            $campos['fecha_actuacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'policivos';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Policivos::create($campos)->id;
            return redirect('juzgados/parte')->with('success', 'Registro de Policivos / Juzgados (Parte) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function juzgados_parte_modal_ver(Request $request){
            $consulta = $request->all();
            $campos = Data_Policivos::where('id', $consulta['id'])->first();
            $campos->tipo_actuacion = Para_Actuacion::where('valor', $campos->tipo_actuacion)->first()->nombre;
            $campos->clase_diligencia = Para_Clase_Diligencia::where('valor', $campos->clase_diligencia)->first()->nombre;
            $campos->despacho_judicial = Para_DespachoJ::where('valor', $campos->despacho_judicial)->first()->nombre;
            $campos->clase = Para_Clase_Policivo::where('valor', $campos->clase)->first()->nombre;
            $campos->observaciones = base64_decode($campos->observaciones);
            $campos->fecha_actuacion = Carbon::parse($campos->fecha_actuacion)->format('d/m/Y');
            $sp = explode('||', $campos->act_sinproc);
            $spd = explode(';', $sp[1]);
            $datos_sinproc = $this->DetalleSinproc($spd, true);
            return view('policivos.juzgados.parte_ver', compact('campos', 'datos_sinproc'));
        }

    //=================================Juzgados Notificaciones =================================
        public function juzgados_notificaciones(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('policivos.juzgados.enteramientos', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function juzgados_notificaciones_listas(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Enteramiento::where('eliminado', false)->where('id_tipo_mp', 4)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $retorno[$i]['txt_unidad'] = Para_Unidad::where('valor', $retorno[$i]['unidad'])->first()->nombre;
                $retorno[$i]['fechaCrea'] = Carbon::parse($retorno[$i]['created_at'])->format('d/m/Y');
                if ($retorno[$i]['archivo_dt'] != '') {
                    $retorno[$i]['btn_acciones'] = '<a  href="/policivos/archivo_notificaciones/'.$retorno[$i]['archivo_dt'].'" class="btn btn-primary"><i class="fas fa-paperclip"></i></a>';
                } else {
                    $retorno[$i]['btn_acciones'] = '';
                }
                
                
            }
            return $retorno;
        }

        public function juzgados_notificaciones_modal(Request $request){
            $parametricas['unidad'] = $this->GenerarSelect(Para_Unidad::where('eliminado', false)->where('id_tipo_mp', 4)->get());
            return view('policivos.juzgados.enteramientos_crear', compact('parametricas'));
        }

        public function juzgados_notificaciones_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['id_tipo_mp'] = 4;
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'policivos';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Enteramiento::create($campos)->id;
            return redirect('juzgados/notificaciones')->with('success', 'Registro de Juzgados (Notificaciones) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

    //=================================Segunda De Oficio =================================
        public function segunda_oficio(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('policivos.segunda.oficio', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function segunda_oficio_actuaciones(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Policivos::where('eliminado', false)->where('tipo_formulario', 1)->where('id_tipo_mp', 5)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $temp = Para_Actuacion::where('valor', $retorno[$i]['tipo_actuacion'])->first()->nombre;
                $retorno[$i]['txt_tipo_actuacion'] = (substr($temp, 0, 2) == '0_') ? str_replace("0_", "", $temp) : $temp;
                $retorno[$i]['txt_clase_diligencia'] = Para_Clase_Diligencia::where('valor', $retorno[$i]['clase_diligencia'])->first()->nombre;
                $retorno[$i]['txt_estado_audiencia'] = ( $retorno[$i]['estado_audiencia'] === null) ? "":Para_Estado_Audiencia::where('valor', $retorno[$i]['estado_audiencia'])->first()->nombre;
                $retorno[$i]['txt_clase'] = Para_Clase_Policivo::where('valor', $retorno[$i]['clase'])->first()->nombre;
                $retorno[$i]['btn_acciones'] = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ');"><i class="far fa-eye"></i></button>';
            }
            return $retorno;
        }

        public function segunda_oficio_modal(Request $request){
            $parametricas['actuacion'] = $this->GenerarSelect(Para_Actuacion::where('eliminado', false)->whereIn('id_tipo_mp', [5])->orderBy('nombre', 'asc')->get());
            $parametricas['clase'] = $this->GenerarSelect(Para_Clase_Policivo::where('eliminado', false)->where('id_tipo_mp', 5)->get());
            $parametricas['autoridad'] = $this->GenerarSelect(Para_Autoridad_Admin::where('eliminado', false)->get());
            $parametricas['sexo'] = $this->ComboSexo();
            $parametricas['identidad'] = $this->ComboIdentidad();
            $parametricas['orientacion'] = $this->ComboOrientacion();
            $parametricas['nacionalidad'] = $this->ComboPaises();
            return view('policivos.segunda.oficio_crear', compact('parametricas'));
        }

        public function segunda_cambio_tipo_actuacion(Request $request){
            $parametros = $request->all();
            $clase_diligencia = Para_Clase_Diligencia::where('eliminado', false)->where('id_actuacion', $parametros['ta'])->get();
            $retorno = array('clase_diligencia' => $this->GenerarSelect($clase_diligencia));
            return $retorno;
        }

        public function segunda_oficio_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['tipo_formulario'] = 1;
            $campos['id_tipo_mp'] = 5;
            $sp = explode('/', $campos['fecha_actuacion']);
            $campos['fecha_actuacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'policivos';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Policivos::create($campos)->id;
            if ($campos['identifica_denunciado'] == 'Si') {
                for ($i=1; $i <= $campos['clicksMas']; $i++) { 
                    $arr = array(
                        'id_tipo_mp' => 5, 
                        'id_actuacion' => $idP1, 
                        'cantidad' => $campos['cantidad_' . $i],
                        'sexo' => $campos['sexo_' . $i],
                        'identidad' => $campos['identidad_' . $i],
                        'orientacion' => $campos['orientacion_' . $i],
                        'nacionalidad' => $campos['nacionalidad_' . $i],
                        'usuario_crea' => $cc
                    );
                    Data_Denunciados::create($arr);
                }
            }
            return redirect('segunda/oficio')->with('success', 'Registro de Policivos / Segunda (Oficio) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function segunda_oficio_modal_ver(Request $request){
            $consulta = $request->all();
            $campos = Data_Policivos::where('id', $consulta['id'])->first();
            $campos->tipo_actuacion = Para_Actuacion::where('valor', $campos->tipo_actuacion)->first()->nombre;
            $campos->clase_diligencia = Para_Clase_Diligencia::where('valor', $campos->clase_diligencia)->first()->nombre;
            $campos->autoridad = Para_Autoridad_Admin::where('valor', $campos->autoridad)->first()->nombre;
            $campos->clase = Para_Clase_Policivo::where('valor', $campos->clase)->first()->nombre;
            $campos->observaciones = base64_decode($campos->observaciones);
            $campos->fecha_actuacion = Carbon::parse($campos->fecha_actuacion)->format('d/m/Y');
            $denunciados = Data_Denunciados::where('id_tipo_mp', 5)->where('id_actuacion', $consulta['id'])->get();
            $obj1 = $this->ComboSexo(true);
            $obj2 = $this->ComboIdentidad(true);
            $obj3 = $this->ComboOrientacion(true);
            $obj4 = $this->ComboPaises(true);
            $rdenunciados = "";
            for ($i=0; $i < count($denunciados); $i++) { 
                for ($x=0; $x < count($obj1); $x++) { 
                    if ($obj1[$x]->valor == $denunciados[$i]['sexo']) {
                        $denunciados[$i]['sexo'] = $obj1[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj2); $x++) { 
                    if ($obj2[$x]->valor == $denunciados[$i]['identidad']) {
                        $denunciados[$i]['identidad'] = $obj2[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj3); $x++) { 
                    if ($obj3[$x]->valor == $denunciados[$i]['orientacion']) {
                        $denunciados[$i]['orientacion'] = $obj3[$x]->nombre;
                    }
                }
                for ($x=0; $x < count($obj4); $x++) { 
                    if ($obj4[$x]->valor == $denunciados[$i]['nacionalidad']) {
                        $denunciados[$i]['nacionalidad'] = $obj4[$x]->nombre;
                    }
                }
                $rdenunciados .= '<div class="row lineaD" style="margin: 20px 0px 10px 0px;"><div class="col-md-4"><label class="minilabel">Sexo</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['sexo'];
                $rdenunciados .= '" disabled></div><div class="col-md-4"><label class="minilabel">Identidad</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['identidad'];
                $rdenunciados .= '" disabled></div><div class="col-md-4"><label class="minilabel">Orientacion</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['orientacion'];
                $rdenunciados .= '" disabled></div><div class="col-md-4" style="padding-top: 20px;"><label class="minilabel">Cantidad</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['cantidad'];
                $rdenunciados .= '" disabled></div><div class="col-md-8" style="padding-top: 20px;"><label class="minilabel">Nacionalidad</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['nacionalidad'];
                $rdenunciados .= '" disabled></div></div>';
            }
            return view('policivos.segunda.oficio_ver', compact('campos', 'rdenunciados'));
        }

    //=================================Segunda De Parte =================================
        public function segunda_parte(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('policivos.segunda.parte', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function segunda_parte_actuaciones(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Policivos::where('eliminado', false)->where('tipo_formulario', 2)->where('id_tipo_mp', 5)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $temp = Para_Actuacion::where('valor', $retorno[$i]['tipo_actuacion'])->first()->nombre;
                $retorno[$i]['txt_tipo_actuacion'] = (substr($temp, 0, 2) == '0_') ? str_replace("0_", "", $temp) : $temp;
                $retorno[$i]['txt_clase_diligencia'] = Para_Clase_Diligencia::where('valor', $retorno[$i]['clase_diligencia'])->first()->nombre;
                $retorno[$i]['txt_estado_audiencia'] = ( $retorno[$i]['estado_audiencia'] === null) ? "":Para_Estado_Audiencia::where('valor', $retorno[$i]['estado_audiencia'])->first()->nombre;
                $retorno[$i]['txt_clase'] = Para_Clase_Policivo::where('valor', $retorno[$i]['clase'])->first()->nombre;
                $sp = explode('||', $retorno[$i]['act_sinproc']);
                $btnVer = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ');" data-toggle="tooltip" data-html="true" title="<b><u>Ver Intervención</u></b>"><i class="fas fa-eye"></i></button>';
                $btnAct = '<button type="button" class="btn btn-primary" onclick="Act(' . $retorno[$i]['id'] . ", '" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Registrar Actuación</u></b>"><i class="fas fa-chalkboard-teacher"></i></button>';
                $btnRem = '<button type="button" class="btn btn-primary" onclick="Rem(' . "'" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Remitir Proceso</u></b>"><i class="fas fa-file-import"></i></button>';
                $btnArc = '<button type="button" class="btn btn-primary" onclick="Arc(' . "'" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Archivar Procesos</u></b>"><i class="fas fa-door-closed"></i></button>';
                if ($this->ChecarSinproc($cedula, $retorno[$i]['sinproc'])) {
                    $cont = Data_Policivos::where('eliminado', false)->where('sinproc', $retorno[$i]['sinproc'])->where('habilitar_archivo', true)->count();
                    if ($cont > 0) {
                        $retorno[$i]['btn_acciones'] = $btnVer.' '.$btnAct.' '.$btnRem.' '.$btnArc;
                    } else{
                        $retorno[$i]['btn_acciones'] = $btnVer.' '.$btnAct.' '.$btnRem;
                    }
                } else {
                    $retorno[$i]['btn_acciones'] = $btnVer;
                }
                $fecha_intervencion = Carbon::parse($retorno[$i]['fecha_actuacion'])->format('d/m/Y');
                $observaciones = base64_decode($retorno[$i]['observaciones']);
                $retorno[$i]['txt_actuacion_sinproc'] = "TIPO DE INTERVENCIÓN: ".$retorno[$i]['txt_tipo_actuacion']."\nCLASE DE DILIGENCIA: ".$retorno[$i]['txt_clase_diligencia']."\nCLASE DE QUERELLA: ".$retorno[$i]['txt_clase']."\nFECHA DE INTERVENCIÓN: ".$fecha_intervencion."\nNO DE QUERELLA: ".$retorno[$i]['numero']."\nOBSERVACIONES: ".$observaciones;
            }
            return $retorno;
        }

        public function segunda_parte_modal(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $parametricas['actuacion'] = $this->GenerarSelect(Para_Actuacion::where('eliminado', false)->whereIn('id_tipo_mp', [5])->orderBy('nombre', 'asc')->get());
            $parametricas['clase'] = $this->GenerarSelect(Para_Clase_Policivo::where('eliminado', false)->where('id_tipo_mp', 5)->get());
            $parametricas['autoridad'] = $this->GenerarSelect(Para_Autoridad_Admin::where('eliminado', false)->get());
            $sinprocs = $this->Sinprocs($cedula);
            return view('policivos.segunda.parte_crear', compact('parametricas', 'sinprocs'));
        }

        public function segunda_parte_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['tipo_formulario'] = 2;
            $campos['id_tipo_mp'] = 5;
            $sp = explode('/', $campos['fecha_actuacion']);
            $campos['fecha_actuacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'policivos';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Policivos::create($campos)->id;
            return redirect('segunda/parte')->with('success', 'Registro de Policivos / Segunda (Parte) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function segunda_parte_modal_ver(Request $request){
            $consulta = $request->all();
            $campos = Data_Policivos::where('id', $consulta['id'])->first();
            $campos->tipo_actuacion = Para_Actuacion::where('valor', $campos->tipo_actuacion)->first()->nombre;
            $campos->clase_diligencia = Para_Clase_Diligencia::where('valor', $campos->clase_diligencia)->first()->nombre;
            $campos->autoridad = Para_Autoridad_Admin::where('valor', $campos->autoridad)->first()->nombre;
            $campos->clase = Para_Clase_Policivo::where('valor', $campos->clase)->first()->nombre;
            $campos->observaciones = base64_decode($campos->observaciones);
            $campos->fecha_actuacion = Carbon::parse($campos->fecha_actuacion)->format('d/m/Y');
            $sp = explode('||', $campos->act_sinproc);
            $spd = explode(';', $sp[1]);
            $datos_sinproc = $this->DetalleSinproc($spd, true);
            return view('policivos.segunda.parte_ver', compact('campos', 'datos_sinproc'));
        }

    //=================================Segunda Notificaciones =================================
        public function segunda_notificaciones(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('policivos.segunda.enteramientos', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function segunda_notificaciones_listas(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Enteramiento::where('eliminado', false)->where('id_tipo_mp', 5)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $retorno[$i]['txt_unidad'] = Para_Autoridad_Admin::where('valor', $retorno[$i]['unidad'])->first()->nombre;
                $retorno[$i]['fechaCrea'] = Carbon::parse($retorno[$i]['created_at'])->format('d/m/Y');
                if ($retorno[$i]['archivo_dt'] != '') {
                    $retorno[$i]['btn_acciones'] = '<a  href="/policivos/archivo_notificaciones/'.$retorno[$i]['archivo_dt'].'" class="btn btn-primary"><i class="fas fa-paperclip"></i></a>';
                } else {
                    $retorno[$i]['btn_acciones'] = '';
                }
                
                
            }
            return $retorno;
        }

        public function segunda_notificaciones_modal(Request $request){
            $parametricas['unidad'] = $this->GenerarSelect(Para_Autoridad_Admin::where('eliminado', false)->get());
            return view('policivos.segunda.enteramientos_crear', compact('parametricas'));
        }

        public function segunda_notificaciones_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['id_tipo_mp'] = 5;
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'policivos';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Enteramiento::create($campos)->id;
            return redirect('segunda/notificaciones')->with('success', 'Registro de Segunda (Notificaciones) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

    //================================= Delegado =================================
        public function policivos_oficio(){
            if ($this->estoy_logeado()) {
                return view('policivos.oficio');
            } else {
                return redirect('login');
            }
        }

        public function policivos_parte(){
            if ($this->estoy_logeado()) {
                return view('policivos.parte');
            } else {
                return redirect('login');
            }
        }

        public function policivos_notificaciones(){
            if ($this->estoy_logeado()) {
                return view('policivos.notificaciones');
            } else {
                return redirect('login');
            }
        }

}
