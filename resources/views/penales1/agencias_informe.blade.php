@extends("plantilla.modal")
@section('modalTitle')
NUEVO INFORME AGENCIA ESPECIAL #{{sprintf("%03d", $idInt)}}
@endsection
@section('modalBtnsHeader')
<button type="button" class="btn btn-secondary" onclick="VerInformes({{$idInt}});" data-toggle="tooltip" data-html="true" title="Informes realizadas"><i class="fas fa-chart-line"></i></button>
@endsection
@section('modalBody')
<form action="{{route('penales1_agencias_informe_guardar')}}" id="formularioInforme" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_agencia_especial" value="{{$idInt}}">
    <input type="hidden" name="numero_agencia_especial" value="{{$agencia->numero_agencia_especial}}">
    <input type="hidden" name="id_periodo_reportado" value="{{$agencia->id_periodo_reportado}}">
    <input type="hidden" name="corregir_delito" id="corregir_delito" value="No">
    <input type="hidden" name="datos_victima" id="datos_victima" value="No">
    <input type="hidden" name="clicksMas" id="clicksMas" value="0">
    <input type="hidden" name="dato_indiciado" id="dato_indiciado" value="No">
    <input type="hidden" name="fin_ae" id="fin_ae" value="No">

    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-info btn-block btn-sm" data-toggle="modal" data-target="#modalDatosAgencia" data-toggle="tooltip" data-html="true" title="Ver datos de constitución de la agencia espacial"><i class="fas fa-balance-scale"></i>&nbsp;&nbsp; DATOS CONSTITUCIÓN AGENCIA ESPECIAL</button>
        </div>
    </div>
    
    <div id="formulario">
        <div class="row top10">
            <div class="col-md-4">
                <label class="requerido minilabel">Fecha de informe</label>
                <input type="text" class="form-control" id="fecha_informe" name="fecha_informe" readonly>
            </div>
            <div class="col-md-8">
                <label class="requerido minilabel">Periodo reportado</label>
                <input type="text" class="form-control" name="periodo_reportado" id="periodo_reportado" value="{{$agencia->periodo_reportado}}" readonly>
            </div>
        </div>
        <div class="row top10">
            <div class="col-md-6">
                <label class="requerido minilabel">Tipo de víctima</label>
                <select class="form-control" id="tipo_victima" name="tipo_victima" onchange="$('#M' + this.id).html('').hide();" >
                    @php echo $parametricas['tipo_victima']; @endphp
                </select>
                <span id="Mtipo_victima" class="msjRequerido"></span>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modalDenunciados"><i class="far fa-id-card"></i>&nbsp;&nbsp; Datos de la victima</button>
            </div>
        </div>
        <div class="row" style="padding-top: 18px;">
            @if ($agencia->id_periodo_reportado == 1)
            <div class="col-md-4">
                <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modalDelito"><i class="fas fa-stamp"></i>&nbsp;&nbsp; ¿Corregir delito?</button>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modalIndiciado"><i class="fas fa-user-lock"></i>&nbsp;&nbsp; ¿Indiciado identificado?</button>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalFinalizar"><i class="fas fa-flag-checkered"></i>&nbsp;&nbsp; Sugerir finalizar AE</button>
            </div>
            @else
            <div class="col-md-6">
                <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modalIndiciado"><i class="fas fa-user-lock"></i>&nbsp;&nbsp; ¿Indiciado identificado?</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalFinalizar"><i class="fas fa-flag-checkered"></i>&nbsp;&nbsp; Sugerir finalizar AE</button>
            </div>
            @endif
        </div>
        <div class="row top10">
            <div class="col-md-12">
                <label class="requerido minilabel">Sintesis de los hechos</label>
                <textarea class="form-control" id="sintesis" rows="3" cols="10" maxlength="1000" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();">{{$agencia->sintesis}}</textarea>
                <input type="hidden" name="sintesis" id="Osintesis">
            </div>
            <div class="col-md-6"><span id="Msintesis" class="msjRequerido"></span></div>
            <div class="col-md-6 text-right" id="cont_sintesis" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
        </div>
        <div class="row top10">
            <div class="col-md-12">
                <label class="requerido minilabel">Actuación procesal</label>
                <textarea class="form-control" id="actuacion_procesal" rows="3" cols="10" maxlength="1000" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();"></textarea>
                <input type="hidden" name="actuacion_procesal" id="Oactuacion_procesal">
            </div>
            <div class="col-md-6"><span id="Mactuacion_procesal" class="msjRequerido"></span></div>
            <div class="col-md-6 text-right" id="cont_actuacion_procesal" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
        </div>
    </div>


    <!-- ************************** Modal Denunciados ************************** -->
    <div class="modal fade" id="modalDenunciados" tabindex="-1" role="dialog" aria-labelledby="modalDenunciadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border: solid 1px #17a2b8;">
                <div class="modal-body">
                    <button type="button" class="btn btn-danger" onclick="$('#modalDenunciados').modal('hide');" style="position: absolute; right: 10px; top: 10px;">
                        <span class="fas fa-times"></span>
                    </button>
                    <div class="row top10" id="rowTablaVictimas" style="display:none;">
                        <div class="col-md-12">
                            <table class="table table-bordered" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th style="padding: 5px;">SEXO</th>
                                        <th style="padding: 5px;">IDENTIDAD</th>
                                        <th style="padding: 5px;">ORIENTACION</th>
                                        <th style="padding: 5px;">NACIONALIDAD</th>
                                        <th style="padding: 5px;">NOMBRE</th>
                                        <th style="padding: 5px;">APELLIDO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($denunciados as $item)
                                    <tr>
                                        <td style="padding: 5px;">{{$item->sexo}}</td>
                                        <td style="padding: 5px;">{{$item->identidad}}</td>
                                        <td style="padding: 5px;">{{$item->orientacion}}</td>
                                        <td style="padding: 5px;">{{$item->nacionalidad}}</td>
                                        <td style="padding: 5px;">{{$item->primer_nombre}}</td>
                                        <td style="padding: 5px;">{{$item->primer_apellido}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" id="paraLinea" style="margin: 0px -10px 0px -10px;">
                        <div class="col-md-8">
                            <span id="texto_victimas">¿Se cuenta con datos de la victima?</span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm" id="btnNo" style="border: 1px solid #dc3545;" onclick="Identifica('No');">No</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm" id="btnSi" onclick="Identifica('Si');">Si</button>
                        </div>
                        <div class="col-md-3 text-center" id="btnPega" style="display: none;">
                            <button type="button" class="btn btn-success btn-sm" onclick="AgregarMas();" style="margin-right: 10px;"><i class="fas fa-plus"></i></button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="AgregarMenos();" style="margin-right: 10px;"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div id="pegar" style="display: none;">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-block btn-sm" onclick="$('#modalDenunciados').modal('hide');"><span class="fa fa-undo"> </span>&nbsp;&nbsp; REGRESAR</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <button type="button" class="btn btn-danger btn-block btn-sm" onclick="$('#modalDenunciados').modal('hide');"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ************************** Modal Delito ************************** -->
    <div class="modal fade" id="modalDelito" tabindex="-1" role="dialog" aria-labelledby="modalDelitoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border: solid 1px #17a2b8;">
                <div class="modal-body">
                    <button type="button" class="btn btn-danger" onclick="$('#modalDelito').modal('hide');" style="position: absolute; right: 10px; top: 10px;">
                        <span class="fas fa-times"></span>
                    </button>
                    <div class="row" style="padding-bottom: 20px;">
                        <div class="col-md-8">
                            ¿Corregir delito?&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm" id="btnDelNo" style="border: 1px solid #dc3545;" onclick="CorregirDelito('No');">No</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm" id="btnDelSi" onclick="CorregirDelito('Si');">Si</button>
                        </div>
                    </div>
                    <div class="row" id="rowDelito" style="margin: 0px -10px 0px -10px;display:none;">
                        <div class="col-md-6">
                            <label class="requerido minilabel">Delito</label>
                            <select class="select2 form-control" id="nuevo_delito" name="nuevo_delito" onchange="$('#M' + this.id).html('').hide();"> 
                                @php echo $parametricas['delito']; @endphp
                            </select>
                            <span id="Mnuevo_delito" class="msjRequerido"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="requerido minilabel">Despacho judicial</label>
                            <select class="select2 form-control" id="nuevo_despacho" name="nuevo_despacho" onchange="$('#M' + this.id).html('').hide();"> 
                                @php echo $parametricas['despacho']; @endphp
                            </select>
                            <span id="Mnuevo_despacho" class="msjRequerido"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-block btn-sm" onclick="$('#modalDelito').modal('hide');"><span class="fa fa-undo"> </span>&nbsp;&nbsp; REGRESAR</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <button type="button" class="btn btn-danger btn-block btn-sm" onclick="$('#modalDelito').modal('hide');"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ************************** Modal Indiciado ************************** -->
    <div class="modal fade" id="modalIndiciado" tabindex="-1" role="dialog" aria-labelledby="modalIndiciadoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border: solid 1px #17a2b8;">
                <div class="modal-body">
                    <button type="button" class="btn btn-danger" onclick="$('#modalIndiciado').modal('hide');" style="position: absolute; right: 10px; top: 10px;">
                        <span class="fas fa-times"></span>
                    </button>
                    <div class="row" style="padding-bottom: 20px;">
                        <div class="col-md-8">
                            ¿Indiciado identificado?&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm" id="btnIndNo" style="border: 1px solid #dc3545;" onclick="ConoceIndiciado('No');">No</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm" id="btnIndSi" onclick="ConoceIndiciado('Si');">Si</button>
                        </div>
                    </div>
                    <div class="row" id="rowIndiciado" style="margin: 0px -10px 0px -10px;display:none;">
                        <div class="col-md-6">
                            <label class="requerido minilabel">Nombre</label>
                            <input type="text" class="form-control" id="nombre_indiciado" name="nombre_indiciado" autocomplete="off" maxlength="255" onkeyup="this.value = FiltrarCaracteres(this, 'nombres');$('#M' + this.id).html('').hide();" value="{{(isset($ultimo_informe[0]->nombre_indiciado) ? $ultimo_informe[0]->nombre_indiciado : '')}}">
                            <span id="Mnombre_indiciado" class="msjRequerido"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="requerido minilabel">Identificación</label>
                            <input type="text" class="form-control" id="indentificacion_indiciado" name="indentificacion_indiciado" autocomplete="off" maxlength="12" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();" value="{{(isset($ultimo_informe[0]->indentificacion_indiciado) ? $ultimo_informe[0]->indentificacion_indiciado : '')}}">
                            <span id="Mindentificacion_indiciado" class="msjRequerido"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-block btn-sm" onclick="$('#modalIndiciado').modal('hide');"><span class="fa fa-undo"> </span>&nbsp;&nbsp; REGRESAR</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <button type="button" class="btn btn-danger btn-block btn-sm" onclick="$('#modalIndiciado').modal('hide');"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ************************** Modal Finalizar ************************** -->
    <div class="modal fade" id="modalFinalizar" tabindex="-1" role="dialog" aria-labelledby="modalFinalizarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border: solid 1px #17a2b8;">
                <div class="modal-body">
                    <button type="button" class="btn btn-danger" onclick="$('#modalFinalizar').modal('hide');" style="position: absolute; right: 10px; top: 10px;">
                        <span class="fas fa-times"></span>
                    </button>
                    <div class="row" style="padding-bottom: 20px;">
                        <div class="col-md-8">
                            ¿Sugerir finalizar la Agencia Especial?&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm" id="btnFinNo" style="border: 1px solid #dc3545;" onclick="FinalizarAE('No');">No</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-sm" id="btnFinSi" onclick="FinalizarAE('Si');">Si</button>
                        </div>
                    </div>
                    <div class="row" id="rowFin" style="margin: 0px -10px 0px -10px;display:none;">
                        <div class="col-md-12">
                            <label class="requerido minilabel">Justificación</label>
                            <textarea class="form-control" id="justificacion" rows="3" cols="10" maxlength="1000" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();" onpaste="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();"></textarea>
                            <input type="hidden" name="justificacion" id="Ojustificacion">
                        </div>
                        <div class="col-md-6"><span id="Mjustificacion" class="msjRequerido"></span></div>
                        <div class="col-md-6 text-right" id="cont_justificacion" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-block btn-sm" onclick="$('#modalFinalizar').modal('hide');"><span class="fa fa-undo"> </span>&nbsp;&nbsp; REGRESAR</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <button type="button" class="btn btn-danger btn-block btn-sm" onclick="$('#modalFinalizar').modal('hide');"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</form>


    <!-- ************************** Modal Datos de la Agencia ************************** -->
    <div class="modal fade" id="modalDatosAgencia" tabindex="-1" role="dialog" aria-labelledby="modalDatosAgenciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border: solid 1px #17a2b8;">
                <div class="modal-body">
                    <button type="button" class="btn btn-danger" onclick="$('#modalDatosAgencia').modal('hide');" style="position: absolute; right: 10px; top: 10px;">
                        <span class="fas fa-times"></span>
                    </button>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="minilabel">Número de agencia especial:</label>
                            <textarea class="form-control" rows="1" disabled style="font-size: 12px; resize: none;">{{sprintf("%03d", $agencia->numero_agencia_especial)}}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="minilabel">Fecha creación</label>
                            <textarea class="form-control" rows="1" disabled style="font-size: 12px; resize: none;">{{$agencia->fecha_creacion}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6">
                            <label class="minilabel" >Delegada asignada</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->delegada}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Nombre del ministerio público</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->nombre_ministerio}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6">
                            <label class="minilabel">No. noticia criminal</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->noticia_criminal}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Despacho judicial</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->despacho_judicial}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6"> 
                            <label class="minilabel">Nombre unidad</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->nombre_unidad}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Adecuación típica actual</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->adecuacion_tipica}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-12">
                            <label class="minilabel">Criterios de creación</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->criterio_creacion}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-12">
                            <label class="minilabel">Justificación</label>
                            <textarea class="form-control" rows="3" disabled style="font-size: 12px;">{{$agencia->justificacion}}</textarea>
                        </div>                        
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-block btn-sm" onclick="$('#modalDatosAgencia').modal('hide');"><span class="fa fa-undo"> </span>&nbsp;&nbsp; REGRESAR</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <button type="button" class="btn btn-danger btn-block btn-sm" onclick="$('#modalDatosAgencia').modal('hide');"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- ************************** Copiar formulario victima ************************** -->
    <div id="copiar" style="display: none;">
        <div class="row" style="margin: 20px 0px 10px 0px;" id="row_@">
            <div class="col-md-4">
                <label class="requerido minilabel">Sexo</label>
                <select class="form-control" id="sexo_@" name="sexo_@" onchange="$('#M' + this.id).html('').hide();"> 
                    @php echo $parametricas['sexo']; @endphp
                </select>
                <span id="Msexo_@" class="msjRequerido"></span>
            </div>
            <div class="col-md-4">
                <label class="requerido minilabel">Identidad</label>
                <select class="form-control" id="identidad_@" name="identidad_@" onchange="$('#M' + this.id).html('').hide();"> 
                    @php echo $parametricas['identidad']; @endphp
                </select>
                <span id="Midentidad_@" class="msjRequerido"></span>
            </div>
            <div class="col-md-4">
                <label class="requerido minilabel">Orientacion</label>
                <select class="form-control" id="orientacion_@" name="orientacion_@" onchange="$('#M' + this.id).html('').hide();"> 
                    @php echo $parametricas['orientacion']; @endphp
                </select>
                <span id="Morientacion_@" class="msjRequerido"></span>
            </div>
            <div class="col-md-4" style="padding-top: 20px;">
                <label class="requerido minilabel">Nombre</label>
                <input type="text" class="form-control" id="nombre_@" name="nombre_@" autocomplete="off" maxlength="255" onkeyup="this.value = FiltrarCaracteres(this, 'nombres');$('#M' + this.id).html('').hide();">
                <span id="Mnombre_@" class="msjRequerido"></span>
            </div>
            <div class="col-md-4" style="padding-top: 20px;">
                <label class="requerido minilabel">Apellido</label>
                <input type="text" class="form-control" id="apellido_@" name="apellido_@" autocomplete="off" maxlength="255" onkeyup="this.value = FiltrarCaracteres(this, 'nombres');$('#M' + this.id).html('').hide();">
                <span id="Mapellido_@" class="msjRequerido"></span>
            </div>
            <div class="col-md-4" style="padding-top: 20px;">
                <label class="requerido minilabel">Nacionalidad</label>
                <select class="form-control" id="nacionalidad_@" name="nacionalidad_@" onchange="$('#M' + this.id).html('').hide();"> 
                    @php echo $parametricas['nacionalidad']; @endphp
                </select>
                <span id="Mnacionalidad_@" class="msjRequerido"></span>
            </div>
        </div>
    </div>



@endsection
@section('modalFooter')
<div class="col-md-6 text-right" id="btnRegistrar">
    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="RegistrarInforme();"><span class="fa fa-save"> </span>&nbsp;&nbsp; REGISTRAR INFORME</button>
</div>
<div class="col-md-6 text-left">
    <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
</div>
@endsection
@section('modalScripts')
<script type="text/javascript">
$('.btn-info').tooltip();
IniciarControlesModal();
var phpMasInforme = "{{$agencia->mas_informe}}";
if (phpMasInforme == 1) {
    $('#tipo_victima').val("{{(isset($ultimo_informe[0]['tipo_victima'])) ? $ultimo_informe[0]['tipo_victima'] : '' }}");
    $('#rowTablaVictimas').show();
    $('#texto_victimas').html('¿Existen más víctimas?');
    $('#sintesis').prop('readonly', true);
} else{
    $('#rowTablaVictimas').hide();
    $('#texto_victimas').html('¿Se cuenta con datos de la victima?');
    $('#sintesis').prop('readonly', false);
}
if ($('#nombre_indiciado').val() != '') {
    ConoceIndiciado('Si');
} else {
    ConoceIndiciado('No');
}
</script>
@endsection