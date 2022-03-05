@extends("plantilla.modal")
@section('modalTitle')
INTERVENCIONES REALIZADAS AGENCIA ESPECIAL #{{sprintf("%03d", $idInt)}}
@endsection
@section('modalBtnsHeader')
@endsection
@section('modalBody')
<table class="table table-bordered" style="font-size: 13px;">
    <thead>
        <tr>
            <th style="padding: 5px;">FECHA</th>
            <th style="padding: 5px;">TIPO INTERVENCIÓN</th>
            <th style="padding: 5px;">CLASE DILIGENCIA</th>
            <th style="padding: 5px;">DESPACHO JUDICIAL</th>
            <th style="width: 43px; padding: 5px;"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($retorno as $item)
            <tr>
                <td style="padding: 5px;">{{$item->fecha_actuacion}}</td>
                <td style="padding: 5px;">{{$item->txt_tipo_actuacion}}</td>
                <td style="padding: 5px;">{{$item->txt_clase_diligencia}}</td>
                <td style="padding: 5px;">{{$item->txt_despacho_judicial}}</td>
                <td style="padding: 5px;"><button type="button" class="btn btn-primary btn-sm" onclick="$('#modalModal').modal('hide');VerOficio({{$item->id}});"><i class="fas fa-eye"></button></i></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('modalFooter')
<div class="col-md-6 text-right" id="btnRegistrar">
    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="$('#modalModal').modal('hide');Int({{$idInt}});"><i class="fas fa-undo"></i>&nbsp;&nbsp; REGRESAR</button>
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