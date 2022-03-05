@extends("plantilla.modal")
@section('modalTitle')
ARCHIVAR EL SINPROC: {{$tk[0]}} VIGENCIA: {{$tk[2]}}
@endsection
@section('modalBtnsHeader')
    
@endsection
@section('modalBody')
<form action="{{config('WSSinproc')}}setArchivo.php" id="formularioArchivo" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="{{$cedula}}" name="cedula">
    <input type="hidden" value="{{config('ModMp')}}wsinproc/archivo/" id="urlBack" name="urlBack">
    <input type="hidden" value="{{$tk[1]}}" name="idTramite">
    <input type="hidden" value="{{$tk[0]}}" name="sinproc">
    <input type="hidden" value="{{$tk[2]}}" name="vigencia">
    <input type="hidden" value="{{$habilitaPMR[1]}}" name="pmr_inicial">
    <div class="row">
        <div class="col-md-12">
            <label class="requerido minilabel">El caso será  archivado y enviado a otra entidad para continuar su gestión</label>
            <select class="form-control" id="rem_externa" name="rem_externa" onchange="$('#M' + this.id).html('').hide(); CambioRemitirEntidad(this.value);" >
                <option value="">-Seleccione Dato-</option>
                <option value="1">SI</option>
                <option value="0">NO</option>
            </select>
            <span id="Mrem_externa" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" id="rowEntExterna" style="display: none;">
        <div class="col-md-12">
            <label class="requerido minilabel">Entidad en la cual continuará trámite del caso</label>
            <select class="selectpicker form-control" data-live-search="true" id="ent_externa" name="ent_externa" onchange="$('#M' + this.id).html('').hide();" >
                @php echo $entExternas; @endphp
            </select>
            <span id="Ment_externa" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" id="rowCordis" style="display: none;">
        <div class="col-md-12">
            <label class="requerido minilabel">Digite el CORDIS con el cual se envía el tramite</label>
            <input type="text" class="form-control" id="numero_cordis" name="numero_cordis" autocomplete="off" maxlength="13" minlength="7" onkeyup="this.value = FiltrarCaracteres(this, 'cordis');$('#M' + this.id).html('').hide();" onblur="ValidarMinimo(this.id, 7, true);" />
            <span id="Mnumero_cordis" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" id="rowArchivoCordis" style="display: none;">
        <div class="col-md-12">
            <label class="requerido minilabel">Seleccione el soporte cordis</label>
            <div class="input-group">
                <input type="file" id="archivo" name="archivo" style="display: none;" onchange="ArchivoValido(this.id, 'pdf;jpg;png', 2);" accept=".pdf, .jpg, .png">
                <input type="text" class="form-control txtArchivo" id="txt_archivo" placeholder="Seleccione un archivo..." readonly onclick="$('#archivo').click();">
                <span class="input-group-btn">
                    <button class="btn btn-warning btn-danger btn-sm" type="button" style="margin: 1px 5px; height: 36px;" onclick="$('#archivo').val('');$('#txt_archivo').val('');$('#Marchivo').html('').hide();">Borrar</button>
                </span>
            </div>
            <span id="Marchivo" class="msjRequerido"></span>
        </div>
    </div>
    @if ($clasificacionPQS != 0)
        <div class="row top10">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert">
                    En la clasificación de P.Q.S seleccionó "SOLICITUD DE COPIAS Y DE INFORMACIÓN", por tal motivo digite la cantidad de folios que entrega al ciudadano / peticionario
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="requerido minilabel">Número de copias</label>
                <input type="text" class="form-control" id="num_copias" name="num_copias" autocomplete="off" maxlength="13" minlength="1" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();" onblur="ValidarMinimo(this.id, 1, true);this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();" />
                <span id="Mnum_copias" class="msjRequerido"></span>
            </div>
        </div>
    @endif
    <div class="row top10">
        <div class="col-md-12">
            <label class="requerido minilabel">Información para su archivo</label>
            <textarea class="form-control" id="informacion" name="informacion" rows="4" cols="50" maxlength="1000" placeholder="Describa el asunto de la Actuación(es) realizada(s)" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();" onblur="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();"></textarea>
        </div>
        <div class="col-md-6"><span id="Minformacion" class="msjRequerido"></span></div>
        <div class="col-md-6 text-right" id="cont_informacion" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
    </div>
    @if ($habilitaPMR[0] == 1)
        <div class="row top10">
            <div class="col-md-12">
                <label class="requerido minilabel">Tema - Cuadro de Control de Requerimientos Ciudadanos</label>
                <select class="form-control" id="pmr" name="pmr" onchange="$('#M' + this.id).html('').hide();" >
                    @php echo $pmr; @endphp
                </select>
                <span id="Mpmr" class="msjRequerido"></span>
            </div>
        </div>
    @endif
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">Tipo de Gestión</label>
            <select class="form-control" id="tipo_gestion" name="tipo_gestion" onchange="$('#M' + this.id).html('').hide();" >
                <option value="">-Seleccione Dato-</option>
                <option value="ORIENTACION">ORIENTACIÓN</option>
                <option value="ASISTENCIA">ASISTENCIA</option>
                <option value="INTERVENCION">INTERVENCIÓN</option>
            </select>
            <span id="Mtipo_gestion" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Elija una opción</label>
            <select class="form-control" id="materializado" name="materializado" onchange="$('#M' + this.id).html('').hide();" >
                <option value="">-Seleccione Dato-</option>
                <option value="1">DERECHO MATERIALIZADO</option>
                <option value="2">DERECHO NO MATERIALIZADO</option>
                <option value="3">SIN INFORMACION</option>
                <option value="4">NO APLICA</option>
            </select>
            <span id="Mmaterializado" class="msjRequerido"></span>
        </div>
    </div>
</form>
@endsection
@section('modalFooter')
<div class="col-md-6 text-right" id="btnRegistrar">
    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="RegistrarArchivoSinproc();"><span class="fa fa-save"> </span>&nbsp;&nbsp; ARCHIVAR TRAMITE</button>
</div>
<div class="col-md-6 text-left">
    <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
</div>
@endsection
@section('modalScripts')
<script type="text/javascript">
var phpClasificacionPQS = {{$clasificacionPQS}};
var phpHabilitaPMR = {{$habilitaPMR[0]}};
IniciarControlesModal();
$('#ent_externa').select2();
</script>
@endsection