<?php

namespace App\Http\Controllers;
date_default_timezone_set('America/Bogota');
setlocale(LC_ALL,"es_CO");

use App\Models\Data_Agencia_Especial;
use App\Models\Para_Delito;
use App\Models\Para_Despacho;
use App\Models\Para_Usuarios;
use DateTime;
use PhpOffice\PhpWord\TemplateProcessor;

class MPGenerarWordController extends Controller
{
    public function agencias($id){
        $agencia = Data_Agencia_Especial::where('eliminado', false)->where('id', $id)->first();
        $templateWord = new TemplateProcessor(storage_path('formatoAgencia.docx'));
        $templateWord->setValue('numeroAE', sprintf("%03d", $agencia->numero_agencia_especial));
        $temp = explode(' ', $agencia->fecha_creacion)[0];
        $sp = explode('-', $temp);
        $string = $sp[2].'/'.$sp[1].'/'.$sp[0];
        $date = DateTime::createFromFormat("d/m/Y", $string);
        $fecha =  strftime("%d de %B de %Y",$date->getTimestamp());
        $templateWord->setValue('fechaCrea', $fecha);
        $templateWord->setValue('nombreMP', Para_Usuarios::where('valor', $agencia->nombre_ministerio)->first()->nombre);
        $templateWord->setValue('cedulaMP', number_format($agencia->nombre_ministerio, 0, ',', '.'));
        $despacho = Para_Despacho::where('valor', $agencia->despacho_judicial)->first();
        $ndespacho = $despacho->codigo . ' ' . $despacho->nombre;
        $templateWord->setValue('despacho', $ndespacho);
        $templateWord->setValue('noticiaC', $agencia->noticia_criminal);
        $templateWord->setValue('delito', Para_Delito::where('valor', $agencia->adecuacion_tipica)->first()->nombre);
        // --- Guardamos el documento
        $nombreArchivo = 'Constitucion Agencia Especial No ' .  sprintf("%03d", $agencia->numero_agencia_especial) . '.docx';
        $templateWord->saveAs(storage_path('temp.docx'));
        $headers = array('Content-Type: application/pdf', 'Content-Type: application/msword',);
        return response()->download(storage_path('temp.docx'), $nombreArchivo, $headers);
    }
}
