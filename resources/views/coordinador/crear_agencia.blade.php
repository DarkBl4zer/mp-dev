@extends("plantilla.modal")
@section('modalTitle')
NUEVA AGENCIA ESPECIAL
@endsection
@section('modalBtnsHeader')
    
@endsection
@section('modalBody')
<form action="{{route('coordinador_guardar')}}" id="formularioAgencia" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <label class="requerido minilabel">Número de agencia especial:</label>
            <input type="text" name="numero_agencia_especial" class="form-control" id="numero_agencia_especial" value="{{$id_disponible}}" style="cursor: not-allowed;" readonly/>
            <span id="Mnumero_agencia_especial" style="color: #e73d4a; display: none;">Campo requerido</span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Fecha creación</label>
            <div class="input-group date">
                <div class="input-group-prepend" id="iconoFechaCrea" onclick="$('#fecha_creacion').focus();" style="cursor: pointer;">
                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt" style="font-size: 20px;"></i></span>
                </div>
                <input type="text" class="form-control pull-right" id="fecha_creacion" name="fecha_creacion" autocomplete="off" readonly>
            </div>
            <span id="Mfecha_creacion" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
                <label class="requerido minilabel" >Delegada asignada</label>
                <select class="form-control" id="delegada" name="delegada" onchange="$('#M' + this.id).hide();CambioTipoActuacion(this.value);" > 
                    @php echo $parametricas['delegada']; @endphp
                </select>
            <span id="Mdelegada" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
                <label class="requerido minilabel">Nombre del ministerio público</label>
                <select class="form-control" id="nombre_ministerio" name="nombre_ministerio" onchange="$('#M' + this.id).hide();" >
                </select>
                <span id="Mnombre_ministerio" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">No. noticia criminal</label>
            <input type="text" class="form-control" id="noticia_criminal" name="noticia_criminal" autocomplete="off" maxlength="21" minlength="21" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).hide();" onblur="ValidarMinimo(this.id, 21);" />
            <span id="Mnoticia_criminal" class="msjRequerido">Número incorrecto</span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Despacho judicial</label>
            <select class="form-control select2" id="despacho_judicial" name="despacho_judicial" onchange="$('#M' + this.id).hide();unidad(this.value);"  >
                @php echo $parametricas['despacho']; @endphp
            </select>
            <span id="Mdespacho_judicial" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6"> 
            <label class="minilabel">Nombre unidad</label>
            <input type="text" class="form-control" name="nombre_unidad"  id="nombre_unidad" onchange="$('#M' + this.id).hide();" style="cursor: not-allowed;" readonly/>
            <span id="Mnombre_unidad" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Adecuación típica actual</label>
            <select class="form-control select2" id="adecuacion_tipica" name="adecuacion_tipica" onchange="$('#M' + this.id).hide();" >
                @php echo $parametricas['adecuacion']; @endphp
            </select>
            <span id="Madecuacion_tipica" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="requerido minilabel">Criterios de creación</label>
            <select class="form-control select2" id="criterio_creacion" name="criterio_creacion"onchange="$('#M' + this.id).hide();" >
                @php echo $parametricas['criterio']; @endphp
            </select>
            <div class="col-md-6"><span id="Mcriterio_creacion" class="msjRequerido"></span></div>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="requerido minilabel">Justificación</label>
            <textarea class="form-control" id="justificacion" rows="3" cols="10" maxlength="1000" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).hide();"></textarea>
            <input type="hidden" name="justificacion" id="Ojustificacion">
        </div>
        <div class="col-md-6"><span id="Mjustificacion" class="msjRequerido"></span></div>
        <div class="col-md-6 text-right" id="cont_justificacion" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
    </div>
</form>
@endsection
@section('modalFooter')
<div class="col-md-6 text-right" id="btnRegistrar">
    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="RegistrarActuacion();"><span class="fa fa-save"> </span>&nbsp;&nbsp; REGISTRAR AGENCIA</button>
</div>
<div class="col-md-6 text-left">
    <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
</div>
@endsection
@section('modalScripts')
<script type="text/javascript">
var idAEDisponible = {{$id_disponible}};
IniciarControlesModal(0);
if (idAEDisponible < 41) {
    $('#fecha_creacion').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        opens: 'right',
        drops: 'down',
        maxDate: moment(),
        locale: SpanishDP,
        isInvalidDate: function(date) {return EsUnDiaValido(date);}
    });
    $('#fecha_creacion').attr('readonly', false);
    $('#fecha_creacion').val('');
} else{
    $('#fecha_creacion').css('cursor', 'not-allowed');
    $('#iconoFechaCrea').css('cursor', 'not-allowed');
}
</script>
@endsection