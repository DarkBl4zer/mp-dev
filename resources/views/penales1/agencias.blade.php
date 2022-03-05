@extends("plantilla.base")
@section('titulo')
PENALES 1 - AGENCIAS
@endsection
@section('plugins')
<!-- DataTables CSS-->
<link rel="stylesheet" href="{{asset("assets/plugins/datatables/datatables.min.css")}}">
<!-- Select2 CSS-->
<link rel="stylesheet" href="{{asset("assets/plugins/select2/css/select2.min.css")}}">
<!-- daterange picker CSS-->
<link rel="stylesheet" href="{{asset("assets/plugins/bootstrap-daterangepicker/daterangepicker.css")}}">

<!-- DataTables JS-->
<script src="{{asset("assets/plugins/datatables/datatables.min.js")}}"></script>
<script type="text/javascript">
    var SpanishDT = "/assets/plugins/datatables/Spanish.json";
</script>
<!-- Select2 JS-->
<script src="{{asset("assets/plugins/select2/js/select2.full.min.js")}}"></script>
<!-- date-range-picker -->
<script src="{{asset("assets/plugins/moment/min/moment.min.js")}}"></script>
<script src="{{asset("assets/plugins/bootstrap-daterangepicker/daterangepicker.js")}}"></script>
<script src="{{asset("assets/plugins/bootstrap-daterangepicker/Spanish.js")}}"></script>
@endsection
@section('regresar')
<a href="{{route('inicio')}}" style="position:fixed; left:-10px; top: 72px; display:block; z-index:99999;">
    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Volver a Principal">
        <i class="fas fa-ellipsis-v"></i> <span style="font-size: 10px; vertical-align: middle;">INTERVENCIÓN</span>
    </button>
</a>
@endsection
@section('contenido')
<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        <strong>PENALES 1 - AGENCIAS</strong>
    </div>
    <div class="card-body">
        <div class="row top10">
            <div class="col-sm-12">
                <table id="tablaDatos" class="table table-bordered table-striped" style="width: 100%; font-size: 13px;">
                </table>
                <div id="noDatos" class="col-md-12 text-center"></div>
            </div>
        </div>
    </div>
</div>


<!-- ************************** Modal Historial ************************** -->
<div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog" aria-labelledby="modalHistorialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border: solid 1px #17a2b8;">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-danger" onclick="$('#modalHistorial').modal('hide');">
                            <span class="fas fa-times"></span>
                        </button>
                    </div>
                </div>
                <div class="row" style="padding-top: 10px;">
                    <div class="col-md-12" id="bodyHistorial"></div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="$('#modalHistorial').modal('hide');"><span class="fa fa-undo"> </span>&nbsp;&nbsp; REGRESAR</button>
                </div>
                <div class="col-md-6 text-left">
                    <button type="button" class="btn btn-danger btn-block btn-sm" onclick="$('#modalHistorial').modal('hide');"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CERRAR</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('codigos')
<script type="text/javascript">
@php
    $ids = "";
    foreach ($noti as $n) {
        $ids .= $n->id_nievel2.';';
    }
    echo 'var notis = "'.$ids.'";';
    echo $festivos;
@endphp
</script>
    <!-- Códigos para Plan de Trabajo -->
    <script src="{{asset("assets/js/penales1/agencias.js")}}"></script>
@endsection