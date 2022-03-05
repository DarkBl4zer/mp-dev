@extends("plantilla.modal")
@section('modalTitle')
NUEVA INTERVENCIÓN DE OFICIO
@endsection
@section('modalBtnsHeader')
    
@endsection
@section('modalBody')
<form action="{{route('movilidad_oficio_guardar')}}" id="formularioOficio" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="btn btn-info btn-block btn-sm"><i class="fas fa-street-view"></i>&nbsp;&nbsp; AFECTADO</div>
        </div>
    </div>
    <div class="row top10" style="padding-bottom: 10px;">
        <div class="col-md-6">
            <label class="requerido minilabel">Tipo documento</label>
            <select class="form-control" id="tipo_documento" name="tipo_documento" onchange="$('#M' + this.id).html('').hide();"> 
                <option value="">-Seleccione Dato-</option>
                <option value="CC||CÉDULA DE CIUDADANÍA">CÉDULA DE CIUDADANÍA</option>
                <option value="CE||CÉDULA DE EXTRANJERIA">CÉDULA DE EXTRANJERIA</option>
                <option value="NI||NO INFORMA">NO INFORMA</option>
                <option value="PA||PASAPORTE">PASAPORTE</option>
                <option value="PE||PERMISO ESPECIAL DE PERMANENCIA">PERMISO ESPECIAL DE PERMANENCIA</option>
                <option value="RC||REGISTRO CIVIL - NUIP">REGISTRO CIVIL - NUIP</option>
                <option value="TI||TARJETA DE IDENTIDAD">TARJETA DE IDENTIDAD</option>
            </select>
            <span id="Mtipo_documento" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Número documento</label>
            <input type="text" class="form-control" id="numero_documento" name="numero_documento" autocomplete="off" minlength="3" maxlength="15" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();" onblur="ValidarMinimo(this.id, 3);">
            <span id="Mnumero_documento" class="msjRequerido"></span>
        </div>
        <div class="col-md-6" style="padding-top: 20px;">
            <label class="requerido minilabel">Primer nombre</label>
            <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" autocomplete="off" onkeyup="this.value = FiltrarCaracteres(this, 'nombres');$('#M' + this.id).html('').hide();">
            <span id="Mprimer_nombre" class="msjRequerido"></span>
        </div>
        <div class="col-md-6" style="padding-top: 20px;">
            <label class="minilabel">Segundo nombre</label>
            <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" autocomplete="off" onkeyup="this.value = FiltrarCaracteres(this, 'nombres');$('#M' + this.id).html('').hide();">
            <span id="Msegundo_nombre" class="msjRequerido"></span>
        </div>
        <div class="col-md-6" style="padding-top: 20px;">
            <label class="requerido minilabel">Primer apellido</label>
            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" autocomplete="off" onkeyup="this.value = FiltrarCaracteres(this, 'nombres');$('#M' + this.id).html('').hide();">
            <span id="Mprimer_apellido" class="msjRequerido"></span>
        </div>
        <div class="col-md-6" style="padding-top: 20px;">
            <label class="minilabel">Segundo apellido</label>
            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" autocomplete="off" onkeyup="this.value = FiltrarCaracteres(this, 'nombres');$('#M' + this.id).html('').hide();">
            <span id="Msegundo_apellido" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" style="border-top: 1px solid #17a2b8;">
        <div class="col-md-6">
            <label class="requerido minilabel">Tipo de intervención</label>
            <select class="form-control" id="tipo_actuacion" name="tipo_actuacion" onchange="$('#M' + this.id).html('').hide();CambioTipoActuacion(this.value);" >
                @php echo $parametricas['actuacion']; @endphp
            </select>
            <span id="Mtipo_actuacion" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Clase de diligencia</label>
            <select class="form-control" id="clase_diligencia" name="clase_diligencia" onchange="$('#M' + this.id).html('').hide();">
            </select>
            <span id="Mclase_diligencia" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" id="row_estado_audiencia" style="display: none;">
        <div class="col-md-12">
            <label class="requerido minilabel">Estado audiencia</label>
            <select class="form-control" id="estado_audiencia" name="estado_audiencia" onchange="$('#M' + this.id).html('').hide();"> 
            </select>
            <span id="Mestado_audiencia" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">Número expediente</label>
            <input type="text" class="form-control" id="numero" name="numero" autocomplete="off" maxlength="8" minlength="8" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();" onblur="ValidarMinimo(this.id, 8);" />
            <span id="Mnumero" class="msjRequerido">Número incorrecto</span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Clase contravención</label>
            <select class="form-control select2" id="clase" name="clase" onchange="$('#M' + this.id).html('').hide();">
                @php echo $parametricas['contravencion']; @endphp
            </select>
            <span id="Mclase" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">Fecha intervención</label>
            <div class="input-group date">
                <div class="input-group-prepend" onclick="$('#fecha_actuacion').click();" style="cursor: pointer;">
                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt" style="font-size: 20px;"></i></span>
                </div>
                <input type="text" class="form-control pull-right" id="fecha_actuacion" name="fecha_actuacion" autocomplete="off"  maxlength="10" minlength="10" onkeyup="this.value = FiltrarCaracteres(this, 'fechas');" onchange="$('#M' + this.id).html('').hide();">
            </div>
            <span id="Mfecha_actuacion" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
            <label class="minilabel">Adjuntar documento</label>
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
    <div class="row top10">
        <div class="col-md-12">
            <label class="requerido minilabel">Observaciones</label>
            <textarea class="form-control" id="observaciones" rows="3" cols="10" maxlength="1000" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();"></textarea>
            <input type="hidden" name="observaciones" id="Oobservaciones">
        </div>
        <div class="col-md-6"><span id="Mobservaciones" class="msjRequerido"></span></div>
        <div class="col-md-6 text-right" id="cont_observaciones" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
    </div>
</form>
@endsection
@section('modalFooter')
<div class="col-md-6 text-right" id="btnRegistrar">
    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="RegistrarActuacion();"><span class="fa fa-save"> </span>&nbsp;&nbsp; REGISTRAR INTERVENCIÓN</button>
</div>
<div class="col-md-6 text-left">
    <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
</div>
@endsection
@section('modalScripts')
<script type="text/javascript">
IniciarControlesModal();
</script>
@endsection