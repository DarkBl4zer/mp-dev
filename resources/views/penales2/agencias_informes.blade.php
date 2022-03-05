@extends("plantilla.modal")
@section('modalTitle')
INFORMES REALIZADOS AGENCIA ESPECIAL #{{sprintf("%03d", $agencia->numero_agencia_especial)}}
@endsection
@section('modalBtnsHeader')
@endsection
@section('modalBody')
<table class="table table-bordered" style="font-size: 13px;">
    <thead>
        <tr>
            <th style="padding: 5px;">FECHA</th>
            <th style="padding: 5px;">PERIODO REPORTADO</th>
            <th style="width: 43px; padding: 5px;"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($informes as $item)
            <tr>
                <td style="padding: 5px;">{{$item->fecha_informe}}</td>
                <td style="padding: 5px;">{{$item->periodo_reportado}}</td>
                <td style="padding: 5px;"><button type="button" class="btn btn-primary btn-sm" onclick="$('#modalModal').modal('hide');VerInforme({{$item->id}});"><i class="fas fa-eye"></button></i></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('modalFooter')
<div class="col-md-6 text-right" id="btnRegistrar">
    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="$('#modalModal').modal('hide');Inf({{$idAE}});"><i class="fas fa-undo"></i>&nbsp;&nbsp; REGRESAR</button>
</div>
<div class="col-md-6 text-left">
    <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
</div>
@endsection
@section('modalScripts')
<script type="text/javascript">
IniciarControlesModal();

function VerInforme(idIn){
    var datos = {idIn: idIn};
    _POST('html', '/penales2/agencias/informe_ver', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
    });
}

</script>
@endsection