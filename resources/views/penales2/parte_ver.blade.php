@extends("plantilla.modal")
@section('modalTitle')
INTERVENCIÓN DE PARTE #{{$campos->id}}
@endsection
@section('modalBtnsHeader')
@php
    $sp = explode('||', $campos->act_sinproc);
    echo '<button type="button" class="btn btn-secondary" onclick="modalHistorico('."'".$sp[1]."'".')"><span class="fas fa-paste "> </span></button>';
@endphp
@endsection
@section('modalBody')
@php
    $sp = explode('||', $campos->act_sinproc);
    $nombreS = $campos->sinproc.' '.$sp[0];
@endphp
<div id="respuestaDetalle"></div>
<div id="contenidoVer">
    <div class="row">
        <div class="col-md-8">
            <label class="requerido minilabel">Sinproc</label>
            <input type="text" class="form-control" value="{{$nombreS}}" disabled/>
        </div>
        <div class="col-md-4" style="padding: 0px 20px 0px 0px;">
            <button type="button" id="btnDatos" class="btn btn-secondary btn-sm btn-block" data-toggle="modal" data-target="#modalDatosBasicos" style="margin: 1px 5px; height: 36px;">
                Datos basicos peticionario(a)
            </button>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="minilabel">Tipo de intervención</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->tipo_actuacion}}</textarea>
        </div>
        <div class="col-md-6">
            <label class="minilabel">Clase de diligencia</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->clase_diligencia}}</textarea>
        </div>
    </div>
    @if ($campos->estado_audiencia != '')
        <div class="row top10">
            <div class="col-md-12">
                <label class="minilabel">Estado audiencia</label>
                <input type="text" class="form-control" value="{{$campos->estado_audiencia}}" disabled style="font-size: 12px; height: 38px;">
            </div>
        </div>
    @endif
    <div class="row top10">
        <div class="col-md-6">
            <label class="minilabel">Criterio de intervención</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->criterio_intervencion}}</textarea>
        </div>
        <div class="col-md-6">
            <label class="minilabel">Despacho judicial</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->despacho_judicial}}</textarea>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="minilabel">No. noticia criminal</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->noticia_criminal}}</textarea>
        </div>
        <div class="col-md-6">
            <label class="minilabel">Delito</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->delito}}</textarea>
        </div>
    </div>
    @if ($campos->numero_cordis != '')
        <div class="row top10">
            <div class="col-md-12">
                <label class="minilabel" >Número CORDIS</label>
                <input type="text" class="form-control" value="{{$campos->numero_cordis}}" disabled style="font-size: 12px; height: 38px;">
            </div>
        </div>
    @endif
    <div class="row top10">
        <div class="col-md-6">
            <label class="minilabel">Fecha intervención</label>
            <input type="text" class="form-control" value="{{$campos->fecha_actuacion}}" disabled style="font-size: 12px; height: 38px;">
        </div>
        <div class="col-md-6">
            <label class="minilabel">Adjuntar documento</label>
            <a href="/penales2/archivo/{{$campos->archivo_dt}}" class="form-control" style="font-size: 12px; min-height: 38px; height: 100%; color: #17a2b8; cursor: pointer; padding-top: 8px;">{{$campos->archivo_or}}</a>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="minilabel">Observaciones</label>
            <textarea class="form-control" rows="3" disabled style="font-size: 12px; resize: none;">{{$campos->observaciones}}</textarea>
        </div>
    </div>

    <!--************************************** Modal Datos Básicos **************************************-->
    <div class="modal fade" id="modalDatosBasicos" tabindex="-1" role="dialog" aria-labelledby="modalDatosBasicosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <strong id="tituloSinproc"></strong>
                            <button type="button" class="close" onclick="$('#modalDatosBasicos').modal('hide');">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="row top10"> 
                        <div class="col-md-12">
                            <label class="minilabel">Observaciones</label>
                            <textarea class="form-control" rows="5" style="font-size: 12px; resize: none;" disabled>{{str_replace('<br />', '', $datos_sinproc->observaciones)}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6">
                            <label class="minilabel">Nombre(s)</label>
                            <input style="font-size: 12px;" type="text" class="form-control" value="{{$datos_sinproc->nombres}}" disabled/>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Apellido(s)</label>
                            <input style="font-size: 12px;" type="text" class="form-control" value="{{$datos_sinproc->apellidos}}" disabled/>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6">
                            <label class="minilabel">Documento de identidad</label>
                            <input style="font-size: 12px;" type="text" class="form-control" value="{{$datos_sinproc->documento}}" disabled/>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Dirección</label>
                            <input style="font-size: 12px;" type="text" class="form-control" value="{{$datos_sinproc->direccion}}" disabled/>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6">
                            <label class="minilabel">Teléfono</label>
                            <input style="font-size: 12px;" type="text" class="form-control" value="{{$datos_sinproc->telefonos}}" disabled/>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Correo Electrónico</label>
                            <input style="font-size: 12px;" type="text" class="form-control" value="{{$datos_sinproc->email}}" disabled/>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6">
                            <label class="minilabel">Género</label>
                            <input style="font-size: 12px;" type="text" class="form-control" value="{{$datos_sinproc->genero}}" disabled/>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Nacionalidad</label>
                            <input style="font-size: 12px;" type="text" class="form-control" value="{{$datos_sinproc->nacionalidad}}" disabled/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modalFooter')

@endsection
@section('modalScripts')
<script type="text/javascript">
$('#modalModal').modal({backdrop: 'static', keyboard: false});
</script>
@endsection