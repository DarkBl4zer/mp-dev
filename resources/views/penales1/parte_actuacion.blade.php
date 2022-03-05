@extends("plantilla.modal")
@section('modalTitle')
ADICIONAR ACTUACIONES AL SINPROC: {{$tk[0]}} VIGENCIA: {{$tk[2]}}
@endsection
@section('modalBtnsHeader')
<button type="button" class="btn btn-secondary" onclick="modalHistorico('{{$tk[0].';'.$tk[1].';'.$tk[2]}}')"><span class="fas fa-paste "> </span></button>
@endsection
@section('modalBody')
<div id="respuestaDetalle"></div>
<form action="{{config('WSSinproc')}}setActuacion.php" id="formularioActuacion" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="{{$cedula}}" name="cedula">
    <input type="hidden" value="{{config('ModMp')}}wsinproc/actuacion/" id="urlBack" name="urlBack">
    <input type="hidden" value="{{$tk[1]}}" name="idTramite">
    <input type="hidden" value="{{$tk[0]}}" name="sinproc" id="sinproc">
    <input type="hidden" value="{{$tk[2]}}" name="vigencia">
    <div class="row">
        <div class="col-md-8">
            <label class="requerido minilabel">Tipo de gestión</label>
            <select class="form-control" id="tipo_gestion" name="tipo_gestion" onchange="$('#M' + this.id).html('').hide();" >
                @php echo $tipoActuacion; @endphp
            </select>
            <span id="Mtipo_gestion" class="msjRequerido"></span>
        </div>
        <div class="col-md-4">
            <label class="requerido minilabel">Fecha actuación</label>
            <div class="input-group date">
                <div class="input-group-prepend" onclick="$('#fecha_gestion').click();" style="cursor: pointer;">
                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt" style="font-size: 20px;"></i></span>
                </div>
                <input type="text" class="form-control pull-right" id="fecha_gestion" name="fecha_gestion" autocomplete="off"  maxlength="10" minlength="10" onkeyup="this.value = FiltrarCaracteres(this, 'fechas');" onchange="$('#M' + this.id).html('').hide();">
            </div>
            <span id="Mfecha_gestion" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="requerido minilabel">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" cols="50" maxlength="1900" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();" onblur="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();"></textarea>
        </div>
        <div class="col-md-6"><span id="Mdescripcion" class="msjRequerido"></span></div>
        <div class="col-md-6 text-right" id="cont_descripcion" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1900</div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="minilabel">Adjuntar documento #1</label>
            <div class="input-group">
                <input type="file" id="Fichier1" name="Fichier1" style="display: none;" onchange="ArchivoValido(this.id, 'pdf', 2);" accept=".pdf">
                <input type="text" class="form-control txtArchivo" id="txt_Fichier1" placeholder="Seleccione un archivo..." readonly onclick="$('#Fichier1').click();">
                <span class="input-group-btn">
                    <button class="btn btn-warning btn-danger btn-sm" type="button" style="margin: 1px 5px; height: 36px;" onclick="$('#Fichier1').val('');$('#txt_Fichier1').val('');$('#MFichier1').html('').hide();">Borrar</button>
                </span>
            </div>
            <span id="MFichier1" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="minilabel">Adjuntar documento #2</label>
            <div class="input-group">
                <input type="file" id="Fichier2" name="Fichier2" style="display: none;" onchange="ArchivoValido(this.id, 'pdf', 2);" accept=".pdf">
                <input type="text" class="form-control txtArchivo" id="txt_Fichier2" placeholder="Seleccione un archivo..." readonly onclick="$('#Fichier2').click();">
                <span class="input-group-btn">
                    <button class="btn btn-warning btn-danger btn-sm" type="button" style="margin: 1px 5px; height: 36px;" onclick="$('#Fichier2').val('');$('#txt_Fichier2').val('');$('#MFichier2').html('').hide();">Borrar</button>
                </span>
            </div>
            <span id="MFichier2" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" style="padding-bottom: 15px;">
        <div class="col-md-12">
            <label class="minilabel">Adjuntar documento #3</label>
            <div class="input-group">
                <input type="file" id="Fichier3" name="Fichier3" style="display: none;" onchange="ArchivoValido(this.id, 'pdf', 2);" accept=".pdf">
                <input type="text" class="form-control txtArchivo" id="txt_Fichier3" placeholder="Seleccione un archivo..." readonly onclick="$('#Fichier3').click();">
                <span class="input-group-btn">
                    <button class="btn btn-warning btn-danger btn-sm" type="button" style="margin: 1px 5px; height: 36px;" onclick="$('#Fichier3').val('');$('#txt_Fichier3').val('');$('#MFichier3').html('').hide();">Borrar</button>
                </span>
            </div>
            <span id="MFichier3" class="msjRequerido"></span>
        </div>
    </div>
</form>
@endsection
@section('modalFooter')
<div class="col-md-6 text-right" id="btnRegistrar">
    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="RegistrarActuacionSinproc();"><span class="fa fa-save"> </span>&nbsp;&nbsp; REGISTRAR ACTUACIÓN</button>
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