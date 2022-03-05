@extends("plantilla.modal")
@section('modalTitle')
INTERVENCIÓN DE OFICIO #{{$campos->id}}
@endsection
@section('modalBtnsHeader')
    
@endsection
@section('modalBody')
<form action="{{route('movilidad_oficio_guardar')}}" id="formularioOficio" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="clicksMas" name="clicksMas" value="0">
    <input type="hidden" id="identifica_denunciado" name="identifica_denunciado" value="No">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-info btn-block btn-sm" data-toggle="modal" data-target="#modalDenunciados"><i class="fas fa-street-view"></i>&nbsp;&nbsp; AFECTADO</button>
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
            <label class="minilabel">Número expediente</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->numero}}</textarea>
        </div>
        <div class="col-md-6">
            <label class="minilabel">Clase contravención</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->clase}}</textarea>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="minilabel">Fecha intervención</label>
            <input type="text" class="form-control" value="{{$campos->fecha_actuacion}}" disabled style="font-size: 12px; height: 38px;">
        </div>
        @if ($campos->archivo_dt != '')
            <div class="col-md-6">
                <label class="minilabel">Adjuntar documento</label>
                <a href="/policivos/archivo/{{$campos->archivo_dt}}" class="form-control" style="font-size: 12px; min-height: 38px; height: 100%; color: #17a2b8; cursor: pointer; padding-top: 8px;">{{$campos->archivo_or}}</a>
            </div>
        @endif
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="minilabel">Observaciones</label>
            <textarea class="form-control" rows="3" disabled style="font-size: 12px; resize: none;">{{$campos->observaciones}}</textarea>
        </div>
    </div>



    <!-- ************************** Modal Denunciados ************************** -->
    <div class="modal fade" id="modalDenunciados" tabindex="-1" role="dialog" aria-labelledby="modalDenunciadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" onclick="$('#modalDenunciados').modal('hide');">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row" style="margin: 20px 0px 10px 0px;">
                        <div class="col-md-6">
                            <label class="minilabel">Tipo documento</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$denunciados->tipo_documento}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Número documento</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$denunciados->numero_documento}}</textarea>
                        </div>
                        <div class="col-md-6" style="padding-top: 20px;">
                            <label class="minilabel">Primer nombre</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$denunciados->primer_nombre}}</textarea>
                        </div>
                        <div class="col-md-6" style="padding-top: 20px;">
                            <label class="minilabel">Segundo nombre</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$denunciados->segundo_nombre}}</textarea>
                        </div>
                        <div class="col-md-6" style="padding-top: 20px;">
                            <label class="minilabel">Primer apellido</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$denunciados->primer_apellido}}</textarea>
                        </div>
                        <div class="col-md-6" style="padding-top: 20px;">
                            <label class="minilabel">Segundo apellido</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$denunciados->segundo_apellido}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</form>
@endsection
@section('modalFooter')
@endsection
@section('modalScripts')
<script type="text/javascript">
IniciarControlesModal();
</script>
@endsection