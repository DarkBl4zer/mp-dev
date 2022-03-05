@extends("plantilla.modal")
@section('modalTitle')
INTERVENCIÓN DE OFICIO #{{$campos->id}}
@endsection
@section('modalBtnsHeader')
    
@endsection
@section('modalBody')
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-info btn-block btn-sm" data-toggle="modal" data-target="#modalDenunciados"><i class="fas fa-street-view"></i>&nbsp;&nbsp; DENUNCIADOS</button>
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
    <div class="row top10">
        <div class="col-md-12">
            <label class="minilabel">Despacho judicial</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->despacho_judicial}}</textarea>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="minilabel">Número proceso</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->numero}}</textarea>
        </div>
        <div class="col-md-6">
            <label class="minilabel">Clase proceso</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->clase}}</textarea>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="minilabel">Fecha intervención</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$campos->fecha_actuacion}}</textarea>
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
                    <div class="row lineaD" style="padding-top: 20px;"></div>
                    @php echo $rdenunciados; @endphp
                </div>
            </div>
        </div>
    </div>


@endsection
@section('modalFooter')
@endsection
@section('modalScripts')
<script type="text/javascript">
IniciarControlesModal();
</script>
@endsection