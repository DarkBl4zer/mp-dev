@extends("plantilla.modal")
@section('modalTitle')
NUEVA INTERVENCIÓN DE OFICIO
@endsection
@section('modalBtnsHeader')
    
@endsection
@section('modalBody')
<form action="{{route('penales2_oficio_guardar')}}" id="formularioOficio" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="clicksMas" name="clicksMas" value="0">
    <input type="hidden" id="identifica_denunciado" name="identifica_denunciado" value="No">
    <div class="row" id="paraLinea" style="margin: 0px -10px 0px -10px; padding-bottom: 10px;">
        <div class="col-md-8">
            ¿Identifica al denunciado?&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-sm" id="btnNo" style="border: 1px solid #dc3545;" onclick="Identifica('No');">No</button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-sm" id="btnSi" onclick="Identifica('Si');">Si</button>
        </div>
        <div class="col-md-4 text-right" id="btnPega" style="display: none;">
            <button type="button" class="btn btn-success btn-sm" onclick="AgregarMas();" style="margin-right: 10px;"><i class="fas fa-plus"></i></button>
            <button type="button" class="btn btn-danger btn-sm" onclick="AgregarMenos();" style="margin-right: 10px;"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div id="pegar" style="display: none;">
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
            <label class="requerido minilabel">Criterio de intervención</label>
                <select class="form-control select2" id="criterio_intervencion" name="criterio_intervencion" onchange="$('#M' + this.id).html('').hide();">
                    @php echo $parametricas['criterios']; @endphp
                </select>
            <span id="Mcriterio_intervencion" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Despacho judicial</label>
            <select class="form-control select2" id="despacho_judicial" name="despacho_judicial" onchange="$('#M' + this.id).html('').hide();">
                @php echo $parametricas['despacho']; @endphp
            </select>
            <span id="Mdespacho_judicial" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">No. noticia criminal</label>
            <input type="text" class="form-control" id="noticia_criminal" name="noticia_criminal" autocomplete="off" maxlength="21" minlength="21" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();" onblur="ValidarMinimo(this.id, 21);" />
            <span id="Mnoticia_criminal" class="msjRequerido">Número incorrecto</span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Delito</label>
            <select class="form-control select2" id="delito" name="delito" onchange="$('#M' + this.id).html('').hide();">
                @php echo $parametricas['delito']; @endphp
            </select>
            <span id="Mdelito" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" id="campoCordis">
        <div class="col-md-12">
            <label class="minilabel">Número CORDIS</label>
            <input type="text" class="form-control" id="numero_cordis" name="numero_cordis" autocomplete="off" maxlength="13" minlength="7" onkeyup="this.value = FiltrarCaracteres(this, 'cordis');$('#M' + this.id).html('').hide();" onblur="ValidarMinimo(this.id, 7, true);" />
            <span id="Mnumero_cordis" class="msjRequerido">Número CORDIS incorrecto</span>
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
            <textarea class="form-control" id="observaciones" rows="3" cols="10" maxlength="1000" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();" onpaste="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();"></textarea>
            <input type="hidden" name="observaciones" id="Oobservaciones">
        </div>
        <div class="col-md-6"><span id="Mobservaciones" class="msjRequerido"></span></div>
        <div class="col-md-6 text-right" id="cont_observaciones" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
    </div>
</form>

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
            <label class="minilabel">Identidad</label>
            <select class="form-control" id="identidad_@" name="identidad_@" onchange="$('#M' + this.id).html('').hide();"> 
                @php echo $parametricas['identidad']; @endphp
            </select>
            <span id="Midentidad_@" class="msjRequerido"></span>
        </div>
        <div class="col-md-4">
            <label class="minilabel">Orientacion</label>
            <select class="form-control" id="orientacion_@" name="orientacion_@" onchange="$('#M' + this.id).html('').hide();"> 
                @php echo $parametricas['orientacion']; @endphp
            </select>
            <span id="Morientacion_@" class="msjRequerido"></span>
        </div>
        <div class="col-md-4" style="padding-top: 20px;">
            <label class="requerido minilabel">Cantidad</label>
            <input type="text" class="form-control" id="cantidad_@" name="cantidad_@" autocomplete="off" maxlength="4" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();">
            <span id="Mcantidad_@" class="msjRequerido"></span>
        </div>
        <div class="col-md-8" style="padding-top: 20px;">
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