<?php

namespace App\Http\Controllers;
date_default_timezone_set('America/Bogota');

use App\Models\Para_Actuacion;
use App\Models\Para_Parametricas;
use App\Models\Para_Roles;
use App\Models\Para_Tipo_MP;
use App\Models\Para_Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MPGestionController extends Controller
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
            if ($rol == 10) {
                return view('gestion.index');
            } else{
                return redirect('/');
            }
        } else {
            return redirect('login');
        }
    }

    public function gestion_lista(){
        $listas = Para_Parametricas::get();
        for ($i=0; $i < count($listas); $i++) { 
            $cont = DB::table($listas[$i]['tabla'])->count();
            $listas[$i]['cantidad'] = $cont;
        }
        return $listas;
    }

    public function gestion_editar($id){
        $lista = Para_Parametricas::where('valor', $id)->first()->nombre;
        $tipoMp = $this->GenerarSelect(Para_Tipo_MP::orderBy('valor')->get());
        $roles = $this->GenerarSelect(Para_Roles::orderBy('valor')->get());
        $masItem = '';
        if ($id != 13 && $id != 14) {
            $tabla = Para_Parametricas::where('valor', $id)->first()->tabla;
            $temp = DB::table($tabla)->orderBy('valor', 'desc')->get();
            $masItem = $temp[0]->valor + 1;
        }
        return view('gestion.editar', compact('id', 'lista', 'tipoMp', 'roles', 'masItem'));
    }

    public function gestion_lista_editar(Request $request){
        $parametros = $request->all();
        $tabla = Para_Parametricas::where('valor', $parametros['id'])->first()->tabla;
        $lista = DB::table($tabla)->get();
        if ($parametros['id'] == 1 || $parametros['id'] == 4 || $parametros['id'] == 3 || $parametros['id'] == 9 || $parametros['id'] == 12) {
            foreach ($lista as $item) {
                $item->id_tipo_mp = Para_Tipo_MP::where('valor', $item->id_tipo_mp)->first()->nombre;
            }
        }
        if ($parametros['id'] == 2) {
            foreach ($lista as $item) {
                $item->id_tipo_mp = Para_Tipo_MP::where('valor', $item->id_tipo_mp)->first()->nombre;
                $item->id_actuacion = Para_Actuacion::where('valor', $item->id_actuacion)->first()->nombre;
            }
        }
        if ($parametros['id'] == 14) {
            foreach ($lista as $item) {
                $item->valor = '<span style="display:none;">'.Carbon::parse($item->valor)->format('Ymd').'</span>'.Carbon::parse($item->valor)->format('d/m/Y');
            }
        }
        return $lista;
    }

    public function gestion_lista_item(Request $request){
        $parametros = $request->all();
        $tabla = Para_Parametricas::where('valor', $parametros['idLista'])->first()->tabla;
        $item = DB::table($tabla)->where('id', $parametros['idItem'])->get();
        return $item;
    }

    public function gestion_lista_guardar(Request $request){
        $sesion = Session::get('UsuarioMp');
        $cc = $sesion[0]['cedula'];
        $msj = "";
        $campos = $request->all();

        if ($campos['idLista'] == 1 || $campos['idLista'] == 4 || $campos['idLista'] == 3 || $campos['idLista'] == 12) {
            $arr = array(
                'id_tipo_mp' => $campos['id_tipo_mp'],
                'valor' => $campos['valor'],
                'nombre' => $campos['nombre']
            );
        } elseif ($campos['idLista'] == 2) {
            $arr = array(
                'id_tipo_mp' => $campos['id_tipo_mp'],
                'id_actuacion' => $campos['id_actuacion'],
                'valor' => $campos['valor'],
                'nombre' => $campos['nombre']
            );
        } elseif ($campos['idLista'] == 8) {
            $arr = array(
                'valor' => $campos['valor'],
                'nombre' => $campos['nombre'],
                'codigo' => $campos['codigo']
            );
        } elseif ($campos['idLista'] == 9) {
            $arr = array(
                'id_tipo_mp' => $campos['id_tipo_mp'],
                'valor' => $campos['valor'],
                'nombre' => $campos['nombre'],
                'codigo' => $campos['codigo']
            );
        } elseif ($campos['idLista'] == 14){
            $sp = explode('/', $campos['valor']);
            $campos['valor'] = $sp[2].'-'.$sp[1].'-'.$sp[0];
            $arr = array(
                'valor' => $campos['valor'],
                'nombre' => $campos['nombre']
            );
        } elseif ($campos['idLista'] == 13){
            if ($campos['id_rol'] == 6 || $campos['id_rol'] == 7 || $campos['id_rol'] == 8 || $campos['id_rol'] == 9) {
                $arrx = array(
                    'id_rol' => 0,
                    'usuario_modifica' => $cc,
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                );
                DB::table('mp_para_usuarios')->where('id_rol', $campos['id_rol'])->update($arrx);
            }
            $arr = array(
                'id_rol' => $campos['id_rol']
            );
        } else{
            $arr = array(
                'valor' => $campos['valor'],
                'nombre' => $campos['nombre']
            );
        }
        $tabla = Para_Parametricas::where('valor', $campos['idLista'])->first()->tabla;
        //Crear nuevo item o actuaclizar (else)
        if ($campos['idItem'] == 0) {
            $msj = 'Registro creado correctamente en el sistema.';
            $arr['usuario_crea'] = $cc;
            $arr['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            DB::table($tabla)->where('id', $campos['idItem'])->insert($arr);
        } else{
            $msj = 'Registro actualizado correctamente en el sistema.';
            $arr['usuario_modifica'] = $cc;
            $arr['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            DB::table($tabla)->where('id', $campos['idItem'])->update($arr);
        }
        return redirect('gestion/editar/'.$campos['idLista'])->with('success', $msj);
    }

    public function gestion_lista_activar_desactivar(Request $request){
        $sesion = Session::get('UsuarioMp');
        $cc = $sesion[0]['cedula'];
        $parametros = $request->all();
        $tabla = Para_Parametricas::where('valor', $parametros['idLista'])->first()->tabla;
        $arr = array(
            'eliminado' => $parametros['tipo'],
            'usuario_modifica' => $cc,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        );
        DB::table($tabla)->where('id', $parametros['idItem'])->update($arr);
        $retorno = array('msj' => 'La tabla paramétrica se ha actualizado correctamente.');
        return $retorno;
    }

    public function gestion_lista_actuaciones_mp(Request $request){
        $parametros = $request->all();
        $actuaciones = $this->GenerarSelect(Para_Actuacion::where('id_tipo_mp', $parametros['mp'])->get(), false, $parametros['select']);
        return $actuaciones;
    }

    public function gestion_lista_actualizar_usuarios(){
        $sesion = Session::get('UsuarioMp');
        $cc = $sesion[0]['cedula'];
        $obj = $this->UsuariosSinproc();
        //Para agregar o actualizar
        for ($i=0; $i < count($obj); $i++) { 
            $cont = Para_Usuarios::where('valor', $obj[$i]->cedula)->count();
            if ($cont > 0) {
                $arr = array(
                    'nombre' => $obj[$i]->nombre, 
                    'email' => $obj[$i]->email, 
                    'idD' => $obj[$i]->idD,  
                    'nombreD' => $obj[$i]->nombreD, 
                    'eliminado' => false,
                    'usuario_modifica' => $cc
                );
                Para_Usuarios::where('valor', $obj[$i]->cedula)->update($arr);
            } else{
                if ($obj[$i]->idD == 52) {
                    $rol = 1;
                } elseif ($obj[$i]->idD == 53) {
                    $rol = 2;
                } else{
                    $rol = 0;
                }
                $arr = array(
                    'id_rol' => $rol,
                    'valor' => $obj[$i]->cedula, 
                    'nombre' => $obj[$i]->nombre, 
                    'email' => $obj[$i]->email, 
                    'idD' => $obj[$i]->idD,  
                    'nombreD' => $obj[$i]->nombreD, 
                    'eliminado' => false,
                    'usuario_crea' => $cc
                );
                Para_Usuarios::create($arr);
            }
        }
        //Para eliminar
        $arrEliminar = array();
        $usuarios = Para_Usuarios::where('valor', '!=', 1010)->get();
        for ($i=0; $i < count($usuarios); $i++) { 
            $eliminar = true;
            foreach ($obj as $item) {
                if ($usuarios[$i]->valor == $item->cedula) {
                    $eliminar = false;
                }
            }
            if ($eliminar) {
                array_push($arrEliminar, $usuarios[$i]->valor);
            }
        }
        $arr = array('eliminado' => true, 'usuario_modifica' => $cc);
        Para_Usuarios::whereIn('valor', $arrEliminar)->update($arr);
        
        $lista = Para_Usuarios::where('eliminado', false)->where('valor', '!=', 1010)->get();
        foreach ($lista as $item) {
            if ($item->id_rol != 0) {
                $item->nombre_rol = Para_Roles::where('valor', $item->id_rol)->first()->nombre;
            } else{
                $item->nombre_rol = '';
            }
        }
        return $lista;
    }
}
