<?php

namespace App\Http\Controllers;
date_default_timezone_set('America/Bogota');

use App\Models\Data_Agencia_Especial;
use App\Models\Data_Agencia_Informe;
use App\Models\Data_Denunciados;
use App\Models\Data_Enteramiento;
use App\Models\Data_Notificaciones;
use App\Models\Data_Penales_Uno;
use App\Models\Para_Actuacion;
use App\Models\Para_Clase_Diligencia;
use App\Models\Para_Criterio_Creacion;
use App\Models\Para_Criterio_Intervencion;
use App\Models\Para_Delegada;
use App\Models\Para_Delito;
use App\Models\Para_Despacho;
use App\Models\Para_Estado_Audiencia;
use App\Models\Para_Tipo_Victima;
use App\Models\Para_Unidad;
use App\Models\Para_Usuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MPPenales1Controller extends Controller
{
    public static function estoy_logeado(){
        if (Session::has('UsuarioMp')){
            return true;
        } else{
            return false;
        }
    }

    //================================= De Oficio =================================
        public function oficio(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('penales1.oficio', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function oficio_actuaciones(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Penales_Uno::where('eliminado', false)->where('tipo_formulario', 1)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $retorno[$i]['txt_tipo_actuacion'] = str_replace("0_", "", Para_Actuacion::where('valor', $retorno[$i]['tipo_actuacion'])->first()->nombre);
                $retorno[$i]['txt_clase_diligencia'] = Para_Clase_Diligencia::where('valor', $retorno[$i]['clase_diligencia'])->first()->nombre;
                $retorno[$i]['txt_estado_audiencia'] = ( $retorno[$i]['estado_audiencia'] === null) ? "":Para_Estado_Audiencia::where('valor', $retorno[$i]['estado_audiencia'])->first()->nombre;
                $despacho = Para_Despacho::where('valor', $retorno[$i]['despacho_judicial'])->first();
                $retorno[$i]['txt_despacho_judicial'] = $despacho->codigo . ' -- ' . $despacho->nombre;
                $retorno[$i]['btn_acciones'] = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ');"><i class="far fa-eye"></i></button>';
            }
            return $retorno;
        }

        public function oficio_modal(Request $request){
            $parametricas['actuacion'] = $this->GenerarSelect(Para_Actuacion::where('eliminado', false)->whereIn('id_tipo_mp', [1,6])->get());
            $parametricas['criterios'] = $this->GenerarSelect(Para_Criterio_Intervencion::where('eliminado', false)->get());
            $parametricas['despacho'] = $this->GenerarSelect(Para_Despacho::where('eliminado', false)->whereIn('id_tipo_mp', [1,6])->get(), true);
            $parametricas['delito'] = $this->GenerarSelect(Para_Delito::where('eliminado', false)->get(), true);
            $parametricas['sexo'] = $this->ComboSexo();
            $parametricas['identidad'] = $this->ComboIdentidad();
            $parametricas['orientacion'] = $this->ComboOrientacion();
            $parametricas['nacionalidad'] = $this->ComboPaises();
            return view('penales1.oficio_crear', compact('parametricas'));
        }

        public function cambio_tipo_actuacion(Request $request){
            $parametros = $request->all();
            $clase_diligencia = Para_Clase_Diligencia::where('eliminado', false)->where('id_actuacion', $parametros['ta'])->get();
            $estado_audiencia = Para_Estado_Audiencia::where('eliminado', false)->whereIn('id_tipo_mp', [1,6])->get();
            $retorno = array('clase_diligencia' => $this->GenerarSelect($clase_diligencia), 'estado_audiencia' => $this->GenerarSelect($estado_audiencia));
            return $retorno;
        }

        public function oficio_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            //dd($campos);
            $campos['usuario_crea'] = $cc;
            $campos['tipo_formulario'] = 1;
            $sp = explode('/', $campos['fecha_actuacion']);
            $campos['fecha_actuacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'penales1';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Penales_Uno::create($campos)->id;
            if ($campos['identifica_denunciado'] == 'Si') {
                for ($i=1; $i <= $campos['clicksMas']; $i++) { 
                    $arr = array(
                        'id_tipo_mp' => 1, 
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
            return redirect('penales1/oficio')->with('success', 'Registro de Penales uno (Oficio) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function oficio_modal_ver(Request $request){
            $consulta = $request->all();
            $campos = Data_Penales_Uno::where('id', $consulta['id'])->first();
            $campos->tipo_actuacion = str_replace("0_", "", Para_Actuacion::where('valor', $campos->tipo_actuacion)->first()->nombre);
            $campos->clase_diligencia = Para_Clase_Diligencia::where('valor', $campos->clase_diligencia)->first()->nombre;
            if (!is_null($campos->estado_audiencia)) {
                $campos->estado_audiencia = Para_Estado_Audiencia::where('valor', $campos->estado_audiencia)->first()->nombre;
            }
            $campos->criterio_intervencion = Para_Criterio_Intervencion::where('valor', $campos->criterio_intervencion)->first()->nombre;
            $despacho = Para_Despacho::where('valor', $campos->despacho_judicial)->first();
            $campos->despacho_judicial = $despacho->codigo . ' -- ' . $despacho->nombre;
            $campos->delito = Para_Delito::where('valor', $campos->delito)->first()->nombre;
            $campos->observaciones = base64_decode($campos->observaciones);
            $campos->fecha_actuacion = Carbon::parse($campos->fecha_actuacion)->format('d/m/Y');
            $denunciados = Data_Denunciados::where('id_tipo_mp', 1)->where('id_actuacion', $consulta['id'])->get();
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
            //return $denunciados;
            return view('penales1.oficio_ver', compact('campos', 'rdenunciados'));
        }

        public function archivo($archivo){
            $archivo_or = Data_Penales_Uno::where('archivo_dt', $archivo)->first()->archivo_or;
            $ptArchivo = storage_path(). '/penales1/' . $archivo;
            return response()->download($ptArchivo, $archivo_or);
        }

    //================================= De Parte =================================
        public function parte(){
            if ($this->estoy_logeado()) {
                $festivos = $this->Festivos();
                return view('penales1.parte', compact('festivos'));
            } else {
                return redirect('login');
            }
        }

        public function parte_actuaciones(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Penales_Uno::where('eliminado', false)->where('tipo_formulario', 2)->where('usuario_crea', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) {
                $retorno[$i]['txt_tipo_actuacion'] = str_replace("0_", "", Para_Actuacion::where('valor', $retorno[$i]['tipo_actuacion'])->first()->nombre);
                $retorno[$i]['txt_clase_diligencia'] = Para_Clase_Diligencia::where('valor', $retorno[$i]['clase_diligencia'])->first()->nombre;
                $retorno[$i]['txt_estado_audiencia'] = ( $retorno[$i]['estado_audiencia'] === null) ? "":Para_Estado_Audiencia::where('valor', $retorno[$i]['estado_audiencia'])->first()->nombre;
                $despacho = Para_Despacho::where('valor', $retorno[$i]['despacho_judicial'])->first();
                $retorno[$i]['txt_despacho_judicial'] = $despacho->codigo . ' -- ' . $despacho->nombre;
                $sp = explode('||', $retorno[$i]['act_sinproc']);
                $btnVer = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ');" data-toggle="tooltip" data-html="true" title="<b><u>Ver Intervención</u></b>"><i class="fas fa-eye"></i></button>';
                $btnAct = '<button type="button" class="btn btn-primary" onclick="Act(' . $retorno[$i]['id'] . ", '" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Registrar Actuación</u></b>"><i class="fas fa-chalkboard-teacher"></i></button>';
                $btnRem = '<button type="button" class="btn btn-primary" onclick="Rem(' . "'" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Remitir Proceso</u></b>"><i class="fas fa-file-import"></i></button>';
                $btnArc = '<button type="button" class="btn btn-primary" onclick="Arc(' . "'" . $sp[1] . "'" . ');" data-toggle="tooltip" data-html="true" title="<b><u>Archivar Procesos</u></b>"><i class="fas fa-door-closed"></i></button>';
                if ($this->ChecarSinproc($cedula, $retorno[$i]['sinproc'])) {
                    $cont = Data_Penales_Uno::where('eliminado', false)->where('sinproc', $retorno[$i]['sinproc'])->where('habilitar_archivo', true)->count();
                    if ($cont > 0) {
                        $retorno[$i]['btn_acciones'] = $btnVer.' '.$btnAct.' '.$btnRem.' '.$btnArc;
                    } else{
                        $retorno[$i]['btn_acciones'] = $btnVer.' '.$btnAct.' '.$btnRem;
                    }
                } else {
                    $retorno[$i]['btn_acciones'] = $btnVer;
                }
                $delito = Para_Delito::where('valor', $retorno[$i]['delito'])->first()->nombre;
                $fecha_intervencion = Carbon::parse($retorno[$i]['fecha_actuacion'])->format('d/m/Y');
                $observaciones = base64_decode($retorno[$i]['observaciones']);
                $retorno[$i]['txt_actuacion_sinproc'] = "TIPO DE INTERVENCIÓN: ".$retorno[$i]['txt_tipo_actuacion']."\nCLASE DE DILIGENCIA: ".$retorno[$i]['txt_clase_diligencia']."\nDESPACHO JUDICIAL: ".$despacho->codigo."\nDELITO: ".$delito."\nFECHA DE INTERVENCIÓN: ".$fecha_intervencion."\nNO DE NOTICIA CRIMINAL: ".$retorno[$i]['noticia_criminal']."\nOBSERVACIONES: ".$observaciones;
            }
            return $retorno;
        }

        public function parte_modal(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $parametricas['actuacion'] = $this->GenerarSelect(Para_Actuacion::where('eliminado', false)->whereIn('id_tipo_mp', [1,6])->get());
            $parametricas['criterios'] = $this->GenerarSelect(Para_Criterio_Intervencion::where('eliminado', false)->get());
            $parametricas['despacho'] = $this->GenerarSelect(Para_Despacho::where('eliminado', false)->whereIn('id_tipo_mp', [1,6])->get(), true);
            $parametricas['delito'] = $this->GenerarSelect(Para_Delito::where('eliminado', false)->get(), true);
            $sinprocs = $this->Sinprocs($cedula);
            return view('penales1.parte_crear', compact('parametricas', 'sinprocs'));
        }

        public function parte_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['tipo_formulario'] = 2;
            $sp = explode('/', $campos['fecha_actuacion']);
            $campos['fecha_actuacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'penales1';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Penales_Uno::create($campos)->id;
            return redirect('penales1/parte')->with('success', 'Registro de Penales uno (Parte) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }
        
        public function parte_modal_ver(Request $request){
            $consulta = $request->all();
            $campos = Data_Penales_Uno::where('id', $consulta['id'])->first();
            $campos->tipo_actuacion = str_replace("0_", "", Para_Actuacion::where('valor', $campos->tipo_actuacion)->first()->nombre);
            $campos->clase_diligencia = Para_Clase_Diligencia::where('valor', $campos->clase_diligencia)->first()->nombre;
            if (!is_null($campos->estado_audiencia)) {
                $campos->estado_audiencia = Para_Estado_Audiencia::where('valor', $campos->estado_audiencia)->first()->nombre;
            }
            $campos->criterio_intervencion = Para_Criterio_Intervencion::where('valor', $campos->criterio_intervencion)->first()->nombre;
            $despacho = Para_Despacho::where('valor', $campos->despacho_judicial)->first(); 
            $campos->despacho_judicial = $despacho->codigo . ' -- ' . $despacho->nombre;
            $campos->delito = Para_Delito::where('valor', $campos->delito)->first()->nombre;
            $campos->observaciones = base64_decode($campos->observaciones);
            $campos->fecha_actuacion = Carbon::parse($campos->fecha_actuacion)->format('d/m/Y');
            $sp = explode('||', $campos->act_sinproc);
            $spd = explode(';', $sp[1]);
            $datos_sinproc = $this->DetalleSinproc($spd, true);
            return view('penales1.parte_ver', compact('campos', 'datos_sinproc'));
        }

        public function parte_guardar_act_sinproc(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $parametros = $request->all();
            $id = Data_Penales_Uno::where('eliminado', false)->where('sinproc', $parametros['sinproc'])->first()->id;
            $arr = array(
                'habilitar_archivo' => true,
                'usuario_modifica' => $cc
            );
            Data_Penales_Uno::find($id)->update($arr);
            return 'true';
        }

    //================================= Enteramientos =================================
        public function enteramientos(){
            if ($this->estoy_logeado()) {
                $sesion = Session::get('UsuarioMp');
                $rol = $sesion[0]['rol'];

                $festivos = $this->Festivos();
                return view('penales1.enteramientos', compact('festivos', 'rol'));
            } else {
                return redirect('login');
            }
        }

        public function enteramientos_listas(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $rol = $sesion[0]['rol'];
            if ($rol == 6) {
                $retorno = Data_Enteramiento::where('eliminado', false)->where('id_tipo_mp', 1)->get();
            } else {
                $retorno = Data_Enteramiento::where('eliminado', false)->where('id_tipo_mp', 1)->where('usuario_crea', $cedula)->get();
            }
            for ($i=0; $i < count($retorno); $i++) { 
                $retorno[$i]['txt_unidad'] = Para_Unidad::where('valor', $retorno[$i]['unidad'])->first()->nombre;
                $retorno[$i]['txt_usuario'] = Para_Usuarios::where('valor', $retorno[$i]['usuario_crea'])->first()->nombre;
                $retorno[$i]['fechaCrea'] = Carbon::parse($retorno[$i]['created_at'])->format('d/m/Y');
                if ($retorno[$i]['archivo_dt'] != '') {
                    $retorno[$i]['btn_acciones'] = '<a  href="/penales1/archivo_enteramientos/'.$retorno[$i]['archivo_dt'].'" class="btn btn-primary"><i class="fas fa-paperclip"></i></a>';
                } else {
                    $retorno[$i]['btn_acciones'] = '';
                }
            }
            return $retorno;
        }

        public function enteramientos_modal(Request $request){
            $parametricas['unidad'] = $this->GenerarSelect(Para_Unidad::where('eliminado', false)->whereIn('id_tipo_mp', [1,6])->get());
            return view('penales1.enteramientos_crear', compact('parametricas'));
        }

        public function enteramientos_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['id_tipo_mp'] = 1;
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'penales1';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Enteramiento::create($campos)->id;
            return redirect('penales1/enteramientos')->with('success', 'Registro de Penales uno (Enteramientos) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function archivo_enteramientos($archivo){
            $archivo_or = Data_Enteramiento::where('archivo_dt', $archivo)->first()->archivo_or;
            $ptArchivo = storage_path(). '/penales1/' . $archivo;
            return response()->download($ptArchivo, $archivo_or);
        }

    //================================= Agencias =================================
        public function agencias(){
            if ($this->estoy_logeado()) {
                $sesion = Session::get('UsuarioMp');
                $id = $sesion[0]['id'];
                $noti = Data_Notificaciones::where('id_usuario', $id)->where('id_nievel1', 1)->get();
                $festivos = $this->Festivos();
                return view('penales1.agencias', compact('noti', 'festivos'));
            } else {
                return redirect('login');
            }
        }

        public function agencias_tabla(){
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Agencia_Especial::where('eliminado', false)->where('nombre_ministerio', $cedula)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $retorno[$i]['numero_agencia_especial'] = sprintf("%03d", $retorno[$i]['numero_agencia_especial']);
                $retorno[$i]['nombre_ministerio'] = Para_Usuarios::where('valor', $retorno[$i]['nombre_ministerio'])->first()->nombre;
                $despacho = Para_Despacho::where('valor', $retorno[$i]['despacho_judicial'])->first();
                $retorno[$i]['despacho_judicial'] = $despacho->codigo . ' -- ' . $despacho->nombre;
                $retorno[$i]['justificacion'] = base64_decode($retorno[$i]['justificacion']);
                $bloqueo = 'false';
                $ultimo_informe = Data_Agencia_Informe::where('id_agencia_especial', $retorno[$i]['id'])->orderBy('id_periodo_reportado', 'desc')->get();
                if (count($ultimo_informe) > 0) {
                    $fechaInf = Carbon::parse($retorno[$i]['fecha_creacion'])->add(5, 'day');
                    $dia = $fechaInf->isoFormat('D');
                    if ($dia <= 15) {
                        $diaBase = $fechaInf->format('Y-m-').'01';
                    } else {
                        $diaBase = $fechaInf->add(1, 'month')->format('Y-m-').'01';
                    }
                    $multiplo = $ultimo_informe[0]['id_periodo_reportado'] * 2;
                    $fechaFin = Carbon::parse($diaBase)->add($multiplo, 'month');
                    $hoy = Carbon::parse(Carbon::now()->format('Y-m-d'));
                    $difDias = $hoy->diffInDays($fechaFin, false);
                    $color = "";
                    if ($difDias >= 40) {
                        $color = '<div class="btn btn-info" style="font-size: 11px;"><span style="font-size: 15px;">'.$difDias.'</span><br> DÍAS DISPONIBLES PARA ENTREGAR EL SIGUIENTE INFORME</div>';
                    } elseif($difDias >= 20) {
                        $color = '<div class="btn btn-success" style="font-size: 11px;"><span style="font-size: 15px;">'.$difDias.'</span><br> DÍAS DISPONIBLES PARA ENTREGAR EL SIGUIENTE INFORME</div>';
                    } elseif($difDias >= 0){
                        $color = '<div class="btn btn-warning" style="font-size: 11px;"><span style="font-size: 15px;">'.$difDias.'</span><br> DÍAS DISPONIBLES PARA ENTREGAR EL SIGUIENTE INFORME</div>';
                    } else{
                        $color = '<div class="btn btn-danger" style="font-size: 11px;">DÍA <span style="font-size: 15px;">'.abs($difDias).'</span><br> DE 5 DÁS MAXIMOS PARA ENTREGAR EL SIGUIENTE INFORME</div>';
                    }
                    $retorno[$i]['dias_informe'] = $color;
                    if ($ultimo_informe[0]['id_periodo_reportado'] > 1) {
                        $ant = $ultimo_informe[0]['id_periodo_reportado'] - 1;
                        $multiplo = $ant * 2;
                        $fechaFin = Carbon::parse($diaBase)->add($multiplo, 'month');
                        $hoy = Carbon::parse(Carbon::now()->format('Y-m-d'));
                        $difDias = $hoy->diffInDays($fechaFin, false);
                        if ($difDias > 0) {
                            $bloqueo = 'true';
                        }
                    }
                }else{
                    $fechaCrea = Carbon::parse($retorno[$i]['fecha_creacion'])->add(5, 'day');
                    $hoy = Carbon::parse(Carbon::now()->format('Y-m-d'));
                    $difDias = $hoy->diffInDays($fechaCrea, false);
                    $color = "";
                    if($difDias >= 3) {
                        $color = '<div class="btn btn-success" style="font-size: 11px;"><span style="font-size: 15px;">'.$difDias.'</span><br> DÍAS DISPONIBLES PARA ENTREGAR EL INFORME DE 5 DÍAS</div>';
                    } elseif($difDias >= 0){
                        $color = '<div class="btn btn-warning" style="font-size: 11px;"><span style="font-size: 15px;">'.$difDias.'</span><br> DÍAS DISPONIBLES PARA ENTREGAR EL INFORME DE 5 DÍAS</div>';
                    } else{
                        $color = '<div class="btn btn-danger" style="font-size: 11px;"><span style="font-size: 15px;">'.abs($difDias).'</span><br> EXCEDIDO DE LA ENTREGA DEL INFORME DE 5 DÍAS</div>';
                    }
                    $retorno[$i]['dias_informe'] = $color;
                }
                $idD = $retorno[$i]['delegada'];
                $inf = '<button type="button" class="btn btn-primary" onclick="Inf(' . $retorno[$i]['id'] . ', ' . $bloqueo . ');" data-toggle="tooltip" data-html="true" title="<b><u>Informe</u></b>"><i class="fas fa-chart-pie"></i></button>';
                $int = '<button type="button" class="btn btn-primary" onclick="Int(' . $retorno[$i]['id'] . ');" data-toggle="tooltip" data-html="true" title="<b><u>Intervención</u></b>"><i class="fas fa-edit"></i></button>';
                $his = '<button type="button" class="btn btn-info" onclick="Historial(' . $retorno[$i]['id'] . ');" data-toggle="tooltip" data-html="true" title="<b><u>Historial</u></b>"><i class="fas fa-history"></i></button>';
                $btnVer = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ', ' . $idD . ');" data-toggle="tooltip" data-html="true" title="<b><u>Ver informes AE</u></b>"><i class="fas fa-eye"></i></button>';
                if ($retorno[$i]['estado'] == 4) {
                    $retorno[$i]['btn_acciones'] = $btnVer;
                } else{
                    if ($retorno[$i]['justificacion_fin'] != '') {
                        $retorno[$i]['btn_acciones'] = $int.' '.$inf.' '.$his;
                    } else{
                        $retorno[$i]['btn_acciones'] = $int.' '.$inf;
                    }
                }
            }
            return $retorno;
        }

        public function agencias_intervencion(Request $request){
            $campos = $request->all();
            $idInt = $campos['id'];
            $agencia = Data_Agencia_Especial::where('id', $idInt)->first();
            $parametricas['actuacion'] = $this->GenerarSelect(Para_Actuacion::where('eliminado', false)->whereIn('id_tipo_mp', [1,6])->get());
            $parametricas['criterios'] = $this->GenerarSelect(Para_Criterio_Intervencion::where('eliminado', false)->get());
            $parametricas['despacho'] = $this->GenerarSelect(Para_Despacho::where('eliminado', false)->whereIn('id_tipo_mp', [1,6])->get(), true, $agencia->despacho_judicial);
            $parametricas['delito'] = $this->GenerarSelect(Para_Delito::where('eliminado', false)->get(), true, $agencia->adecuacion_tipica);
            $parametricas['sexo'] = $this->ComboSexo();
            $parametricas['identidad'] = $this->ComboIdentidad();
            $parametricas['orientacion'] = $this->ComboOrientacion();
            $parametricas['nacionalidad'] = $this->ComboPaises();
            return view('penales1.agencias_intervencion', compact('parametricas', 'idInt', 'agencia'));
        }

        public function agencias_intervencion_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $campos['tipo_formulario'] = 3;
            $sp = explode('/', $campos['fecha_actuacion']);
            $campos['fecha_actuacion'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            if (isset($campos['archivo'])) {
                $File = $campos['archivo'];
                $sub_path = 'penales1';
                $original = $File->getClientOriginalName();
                $destination_path = storage_path($sub_path);
                $date = Carbon::now()->format('YmdHisu');
                $nombArchivo = $date;
                $File->move($destination_path,  $nombArchivo);
                $campos['archivo_dt'] = $nombArchivo;
                $campos['archivo_or'] = $original;
            }
            $idP1 = Data_Penales_Uno::create($campos)->id;
            if ($campos['identifica_denunciado'] == 'Si') {
                for ($i=1; $i <= $campos['clicksMas']; $i++) { 
                    $arr = array(
                        'id_tipo_mp' => 1, 
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
            return redirect('penales1/agencias')->with('success', 'Registro de Agencias especiales (Intervención) creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function agencias_intervenciones(Request $request){
            $campos = $request->all();
            $idInt = $campos['id'];
            $sesion = Session::get('UsuarioMp');
            $cedula = $sesion[0]['cedula'];
            $retorno = Data_Penales_Uno::where('eliminado', false)->where('tipo_formulario', 3)->where('agencia_especial', $idInt)->get();
            for ($i=0; $i < count($retorno); $i++) { 
                $retorno[$i]['txt_tipo_actuacion'] = str_replace("0_", "", Para_Actuacion::where('valor', $retorno[$i]['tipo_actuacion'])->first()->nombre);
                $retorno[$i]['txt_clase_diligencia'] = Para_Clase_Diligencia::where('valor', $retorno[$i]['clase_diligencia'])->first()->nombre;
                $retorno[$i]['txt_estado_audiencia'] = ( $retorno[$i]['estado_audiencia'] === null) ? "":Para_Estado_Audiencia::where('valor', $retorno[$i]['estado_audiencia'])->first()->nombre;
                $despacho = Para_Despacho::where('valor', $retorno[$i]['despacho_judicial'])->first();
                $retorno[$i]['txt_despacho_judicial'] = $despacho->codigo . ' -- ' . $despacho->nombre;
                $retorno[$i]['btn_acciones'] = '<button type="button" class="btn btn-primary" onclick="Ver(' . $retorno[$i]['id'] . ');"><i class="far fa-eye"></i></button>';
                $retorno[$i]['fecha_actuacion'] = Carbon::parse($retorno[$i]['fecha_actuacion'])->format('d/m/Y');
            }
            return view('penales1.agencias_intervenciones', compact('retorno', 'idInt'));
        }

        public function agencias_informe(Request $request){
            $campos = $request->all();
            $idInt = $campos['id'];
            $agencia = Data_Agencia_Especial::where('id', $idInt)->first();
            $agencia['fecha_creacion'] = Carbon::parse($agencia->fecha_creacion)->format('d/m/Y');
            $agencia['delegada'] = Para_Delegada::where('valor', $agencia->delegada)->first()->nombre;
            $agencia['nombre_ministerio'] = Para_Usuarios::where('valor', $agencia->nombre_ministerio)->first()->nombre;
            $despacho = Para_Despacho::where('valor', $agencia->despacho_judicial)->first();
            $agencia['despacho_judicial'] = $despacho->codigo . ' -- ' . $despacho->nombre;
            $agencia['adecuacion_tipica'] = Para_Delito::where('valor', $agencia->adecuacion_tipica)->first()->nombre;
            $agencia['criterio_creacion'] = Para_Criterio_Creacion::where('valor', $agencia->criterio_creacion)->first()->nombre;
            $agencia['justificacion'] = base64_decode($agencia->justificacion);
            $agencia['sintesis'] = base64_decode($agencia->sintesis);
            $parametricas['tipo_victima'] =  $this->GenerarSelect(Para_Tipo_Victima::where('eliminado', false)->get());
            $parametricas['sexo'] = $this->ComboSexo();
            $parametricas['identidad'] = $this->ComboIdentidad();
            $parametricas['orientacion'] = $this->ComboOrientacion();
            $parametricas['nacionalidad'] = $this->ComboPaises();
            $parametricas['despacho'] = $this->GenerarSelect(Para_Despacho::where('eliminado', false)->whereIn('id_tipo_mp', [1,6])->get(), true);
            $parametricas['delito'] = $this->GenerarSelect(Para_Delito::where('eliminado', false)->get(), true);

            $denunciados = Data_Denunciados::where('id_tipo_mp', 99)->where('id_actuacion', $idInt)->get();
            $obj1 = $this->ComboSexo(true);
            $obj2 = $this->ComboIdentidad(true);
            $obj3 = $this->ComboOrientacion(true);
            $obj4 = $this->ComboPaises(true);
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
            }

            $ultimo_informe = Data_Agencia_Informe::where('id_agencia_especial', $idInt)->orderBy('id_periodo_reportado', 'desc')->get();
            if (count($ultimo_informe) > 0) {
                $agencia['periodo_reportado'] = 'INFORME BIMENSUAL #' . $ultimo_informe[0]['id_periodo_reportado'];
                $agencia['id_periodo_reportado'] = $ultimo_informe[0]['id_periodo_reportado'] + 1;
                $agencia['mas_informe'] = true;
            }else{
                $agencia['periodo_reportado'] = 'INFORME 5 DÍAS';
                $agencia['id_periodo_reportado'] = 1;
                $agencia['mas_informe'] = false;
            }

            return view('penales1.agencias_informe', compact('agencia', 'idInt', 'parametricas', 'ultimo_informe', 'denunciados'));
        }

        public function agencias_informe_guardar(Request $request){
            $sesion = Session::get('UsuarioMp');
            $cc = $sesion[0]['cedula'];
            $nombreU = $sesion[0]['nombre'];

            $campos = $request->all();
            $campos['usuario_crea'] = $cc;
            $sp = explode('/', $campos['fecha_informe']);
            $campos['fecha_informe'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            $this->eliminar_notificacion(1, $campos['id_agencia_especial']);
            $idP1 = Data_Agencia_Informe::create($campos)->id;
            if ($campos['datos_victima'] == 'Si') {
                for ($i=1; $i <= $campos['clicksMas']; $i++) { 
                    $arr = array(
                        'id_tipo_mp' => 99, 
                        'id_actuacion' => $campos['id_agencia_especial'], 
                        'primer_nombre' => $campos['nombre_' . $i],
                        'primer_apellido' => $campos['apellido_' . $i],
                        'sexo' => $campos['sexo_' . $i],
                        'identidad' => $campos['identidad_' . $i],
                        'orientacion' => $campos['orientacion_' . $i],
                        'nacionalidad' => $campos['nacionalidad_' . $i],
                        'usuario_crea' => $cc
                    );
                    Data_Denunciados::create($arr);
                }
            }
            if ($campos['id_periodo_reportado'] == 1) {
                $arr = array(
                    'sintesis' => $campos['sintesis'],
                    'estado' => 2,
                    'usuario_modifica' => $cc
                );
                Data_Agencia_Especial::find($campos['id_agencia_especial'])->update($arr);
            }
            if ($campos['fin_ae'] == 'Si') {
                $date = Carbon::now()->format('d/m/Y');
                $jus_anterior = base64_decode(Data_Agencia_Especial::where('id', $campos['id_agencia_especial'])->first()->justificacion_fin);
                $jus_nueva = base64_decode($campos['justificacion']);
                $justificacion_fin = base64_encode($jus_anterior . "||".$nombreU."<br>\n[".$date."]((" . $jus_nueva);
                $mp = Para_Usuarios::where('id_rol', 9)->first();
                $this->crear_notificacion($mp->id, 1, $campos['id_agencia_especial']);
                $arr = array(
                    'estado' => 3,
                    'justificacion_fin' => $justificacion_fin,
                    'usuario_modifica' => $cc
                );
                Data_Agencia_Especial::find($campos['id_agencia_especial'])->update($arr);
            }
            return redirect('penales1/agencias')->with('success', 'Registro de Informe de Agencia Especial #'.$campos['numero_agencia_especial'].' creado correctamente en el sistema con el id: ' . $idP1 . '.');
        }

        public function agencias_informes(Request $request){
            $campos = $request->all();
            $idAE = $campos['idAE'];
            $agencia = Data_Agencia_Especial::where('id', $idAE)->first();
            $informes = Data_Agencia_Informe::where('eliminado', false)->where('id_agencia_especial', $idAE)->get();
            for ($i=0; $i < count($informes); $i++) { 
                $informes[$i]['fecha_informe'] = Carbon::parse($informes[$i]['fecha_informe'])->format('d/m/Y');
            }
            return view('penales1.agencias_informes', compact('agencia', 'informes', 'idAE'));
        }

        public function agencias_informe_ver(Request $request){
            $campos = $request->all();
            $idIn = $campos['idIn'];

            $informe = Data_Agencia_Informe::where('eliminado', false)->where('id', $idIn)->first();
            $informe['fecha_informe'] = Carbon::parse($informe['fecha_informe'])->format('d/m/Y');
            $informe['tipo_victima'] = Para_Tipo_Victima::where('valor', $informe['tipo_victima'])->first()->nombre;
            $informe['actuacion_procesal'] = base64_decode($informe->actuacion_procesal);
            if ($informe['nuevo_delito'] != '') {
                $informe['nuevo_delito'] = Para_Delito::where('valor', $informe['nuevo_delito'])->first()->nombre;
            }
            if ($informe['nuevo_despacho'] != '') {
                $despacho = Para_Despacho::where('valor', $informe['nuevo_despacho'])->first();
                $informe['nuevo_despacho'] = $despacho->codigo . ' -- ' . $despacho->nombre;
            }
            $agencia = Data_Agencia_Especial::where('id', $informe->id_agencia_especial)->first();
            $agencia['fecha_creacion'] = Carbon::parse($agencia->fecha_creacion)->format('d/m/Y');
            $agencia['delegada'] = Para_Delegada::where('valor', $agencia->delegada)->first()->nombre;
            $agencia['nombre_ministerio'] = Para_Usuarios::where('valor', $agencia->nombre_ministerio)->first()->nombre;
            $despacho = Para_Despacho::where('valor', $agencia->despacho_judicial)->first();
            $agencia['despacho_judicial'] = $despacho->codigo . ' -- ' . $despacho->nombre;
            $agencia['adecuacion_tipica'] = Para_Delito::where('valor', $agencia->adecuacion_tipica)->first()->nombre;
            $agencia['criterio_creacion'] = Para_Criterio_Creacion::where('valor', $agencia->criterio_creacion)->first()->nombre;
            $agencia['justificacion'] = base64_decode($agencia->justificacion);
            $agencia['sintesis'] = base64_decode($agencia->sintesis);
            
            $denunciados = Data_Denunciados::where('id_tipo_mp', 99)->where('id_actuacion', $agencia['id'])->get();
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
                $rdenunciados .= '" disabled></div><div class="col-md-4" style="padding-top: 20px;"><label class="minilabel">Nombre</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['primer_nombre'];
                $rdenunciados .= '" disabled></div><div class="col-md-4" style="padding-top: 20px;"><label class="minilabel">Apellido</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['primer_apellido'];
                $rdenunciados .= '" disabled></div><div class="col-md-4" style="padding-top: 20px;"><label class="minilabel">Nacionalidad</label><input type="text" class="form-control" value="';
                $rdenunciados .= $denunciados[$i]['nacionalidad'];
                $rdenunciados .= '" disabled></div></div>';
            }

            return view('penales1.agencias_informe_ver', compact('informe', 'agencia', 'rdenunciados'));
        }

}
