@extends("plantilla.modal")
@section('modalTitle')
@php
    echo $informe['titulo'];
@endphp
@endsection
@section('modalBtnsHeader')
@endsection
@section('modalBody')
<div class="row top10">
    <div class="col-sm-12">
        <button type="button" class="btn btn-success btn-sm" onclick="$('.buttons-excel').click();" style="background-color: #006f19; border-color: #006f19"><i class="fas fa-file-excel"></i> Exportar</button>
    </div>
</div>
<table id="tablaGeneral" class="table table-bordered table-striped" style="font-size: 13px;">
    <thead style="background-color: #003e65 !important; color: white !important;">
        <tr>
            <th style="padding: 5px;" id="titulo_uno"></th>
            <th style="padding: 5px; text-align: center;" id="titulo_dos"></th>
            <th style="padding: 5px; text-align: center;" id="titulo_tes"></th>
            <th style="padding: 5px; text-align: center;" id="titulo_cuatro"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($informe['general'] as $item)
            @if ($item['total'] != 0)
            <tr>
                <td style="padding: 5px;">{{$item['actuacion']}}</td>
                <td style="padding: 5px; text-align: center;"><button type="button" onclick="GenerarDetalle(1, {{$item['id_actuacion']}});" class="btn btn-outline-success btn-sm btn-block">{{$item['oficio']}}</button></td>
                <td style="padding: 5px; text-align: center;"><button type="button" onclick="GenerarDetalle(2, {{$item['id_actuacion']}});" class="btn btn-outline-success btn-sm btn-block">{{$item['parte']}}</button></td>
                <td style="padding: 5px; text-align: center;"><button type="button" onclick="GenerarDetalle(3, {{$item['id_actuacion']}});" class="btn btn-outline-success btn-sm btn-block">{{$item['total']}}</button></td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>
<form target="_blank" action="{{route('estadisticas_informe_detalle')}}" id="formDetalle" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="delegada" name="delegada">
    <input type="hidden" id="tipo" name="tipo">
    <input type="hidden" id="actuacion" name="actuacion">
</form>
@endsection
@section('modalFooter')

@endsection
@section('modalScripts')
<script type="text/javascript">
var tipo = "{{$informe['tipo']}}";
if (tipo == "6") {
    $('#titulo_uno').html('DELEGADA');
    $('#titulo_dos').html('DE OFICIO');
    $('#titulo_tes').html('DE PARTE');
    $('#titulo_cuatro').html('TOTAL');
} else if (tipo == "7") {
    $('#titulo_uno').html('DELEGADA');
    $('#titulo_dos').html('ABIERTAS');
    $('#titulo_tes').html('FINALIZADAS');
    $('#titulo_cuatro').html('TOTAL');
} else{
    $('#titulo_uno').html('INTERVENCIÓN');
    $('#titulo_dos').html('DE OFICIO');
    $('#titulo_tes').html('DE PARTE');
    $('#titulo_cuatro').html('TOTAL');
}
var texto = "{{$informe['titulo']}}";
var titulo = texto + '    ' + DDMMYYYY(new Date());
var archivo = texto.replace(/ /g, "_") + '_' +  DDMMYYYY(new Date()).replace(/\//g, "-"); 
$('#tablaGeneral').DataTable({
    bSort: false,
    paging: false,
    dom: 'B',
    buttons: [{extend: 'excelHtml5', title: titulo, filename: archivo}],
    language: { url: SpanishDT }
});
$('#modalModal').modal({backdrop: 'static', keyboard: false});
</script>
@endsection