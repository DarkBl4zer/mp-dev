@extends("plantilla.modal")
@section('modalTitle')
REMITIR EL SINPROC: {{$tk[0]}} VIGENCIA: {{$tk[2]}}
@endsection
@section('modalBtnsHeader')
    
@endsection
@section('modalBody')
<form action="{{config('WSSinproc')}}setRemision.php" id="formularioRemision" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="{{$cedula}}" name="cedula">
    <input type="hidden" value="{{config('ModMp')}}wsinproc/remision/" id="urlBack" name="urlBack">
    <input type="hidden" value="{{$tk[1]}}" name="idTramite">
    <input type="hidden" value="{{$tk[0]}}" name="sinproc">
    <input type="hidden" value="{{$tk[2]}}" name="vigencia">
    <input type="hidden" id="remitir_a" name="remitir_a">
    <div class="row">
        <div class="col-md-12">
            <label class="requerido minilabel">Seleccione la dependencia a remitir</label>
            <select class="form-control" id="dep_remision" name="dep_remision" onchange="$('#M' + this.id).html('').hide(); EnviarUsuario(this.value);" >
                @php echo $dependencias; @endphp
            </select>
            <span id="Mdep_remision" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" id="rowSUsuario" style="display: none;">
        <div class="col-md-12">
            <label class="requerido minilabel">Seleccione el usuario al cual remitirá el caso</label>
            <select class="form-control" id="susuario" onchange="$('#M' + this.id).html('').hide(); $('#remitir_a').val(this.value);" >
                @php echo $usuarios_dependencia; @endphp
            </select>
            <span id="Msusuario" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="requerido minilabel">Información para su remisión</label>
            <textarea class="form-control" id="informacion" name="informacion" rows="4" cols="50" maxlength="1000" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();" onblur="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();"></textarea>
        </div>
        <div class="col-md-6"><span id="Minformacion" class="msjRequerido"></span></div>
        <div class="col-md-6 text-right" id="cont_informacion" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
    </div>
</form>
@endsection
@section('modalFooter')
<div class="col-md-6 text-right" id="btnRegistrar">
    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="RegistrarRemisionSinproc();"><span class="fa fa-save"> </span>&nbsp;&nbsp; REMITIR TRAMITE</button>
</div>
<div class="col-md-6 text-left">
    <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
</div>
@endsection
@section('modalScripts')
<script type="text/javascript">
var phpDelegada = "{{$delegada}}";
IniciarControlesModal();
</script>
@endsection