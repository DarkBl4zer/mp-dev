@extends("plantilla.modal")
@section('modalTitle')
NUEVA NOTIFICACIÓN
@endsection
@section('modalBtnsHeader')
    
@endsection
@section('modalBody')
<form action="{{route('juzgados_notificaciones_guardar')}}" id="formularioEnteramientos" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <label class="requerido minilabel">Unidad</label>
            <select class="form-control select2" id="unidad" name="unidad" onchange="$('#M' + this.id).hide();">
                @php echo $parametricas['unidad']; @endphp
            </select>
        <span id="Munidad" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">Cantidad</label>
            <input type="text" class="form-control" id="cantidad" name="cantidad" autocomplete="off"  maxlength="4" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).hide();">
            <div class="col-md-6"><span id="Mcantidad" class="msjRequerido"></span></div>
        </div>
        <div class="col-md-6">
            <label class="minilabel">Adjuntar documento</label>
            <div class="input-group">
                <input type="file" id="archivo" name="archivo" style="display: none;" onchange="ArchivoValido(this.id, 'pdf;jpg;png;xlsx', 2);" accept=".pdf, .jpg, .png, .xlsx">
                <input type="text" class="form-control txtArchivo" id="txt_archivo" placeholder="Seleccione un archivo..." readonly onclick="$('#archivo').click();">
                <span class="input-group-btn">
                    <button class="btn btn-warning btn-danger btn-sm" type="button" style="margin: 1px 5px; height: 36px;" onclick="$('#archivo').val('');$('#txt_archivo').val('');$('#Marchivo').html('').hide();">Borrar</button>
                </span>
            </div>
            <span id="Marchivo" class="msjRequerido"></span>
        </div>
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