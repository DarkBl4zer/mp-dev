@extends("plantilla.base")
@section('titulo')
INFORMES ESTADÍSTICOS
@endsection
@section('plugins')
<!-- DataTables CSS-->
<link rel="stylesheet" href="{{asset("assets/plugins/datatables/datatables.min.css")}}">
<!-- DataTables Botones CSS-->
<link rel="stylesheet" href="{{asset("assets/plugins/datatables/Buttons-1.5.6/css/buttons.bootstrap4.css")}}">
<!-- Select2 CSS-->
<link rel="stylesheet" href="{{asset("assets/plugins/select2/css/select2.min.css")}}">
<!-- daterange picker CSS-->
<link rel="stylesheet" href="{{asset("assets/plugins/bootstrap-daterangepicker/daterangepicker.css")}}">

<!-- DataTables JS-->
<script src="{{asset("assets/plugins/datatables/datatables.min.js")}}"></script>
<script type="text/javascript">
    var SpanishDT = "/assets/plugins/datatables/Spanish.json";
</script>
<!-- DataTables Botones JS-->
<script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.js")}}"></script>
<script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/buttons.bootstrap4.js")}}"></script>
<script src="{{asset("assets/plugins/datatables/JSZip-2.5.0/jszip.js")}}"></script>
<script src="{{asset("assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js")}}"></script>
<script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/buttons.html5.js")}}"></script>
<script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/buttons.print.js")}}"></script>
<script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/buttons.colVis.js")}}"></script>
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
        <strong>INFORMES ESTADÍSTICOS</strong>
    </div>
    <div class="card-body">
        @if ($rol==1 || $rol==6 || $rol==9 ||$rol==10)
            <div class="row" style="padding-top: 20px;">
                <div class="col-sm-2">
                    <button onclick="InformeGeneral(1);" type="button" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> PEN1</button>
                </div>
                <div class="col-sm-10">
                    <button onclick="InformeGeneral(1);" type="button" class="btn btn-primary" style="width: 100%;text-align: left;">INFORME PENALES 1</button>
                </div>
            </div>
        @endif
        @if ($rol==2 || $rol==7 || $rol==9 ||$rol==10)
            <div class="row" style="padding-top: 20px;">
                <div class="col-sm-2">
                    <button onclick="InformeGeneral(2);" type="button" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> PEN2</button>
                </div>
                <div class="col-sm-10">
                    <button onclick="InformeGeneral(2);" type="button" class="btn btn-primary" style="width: 100%;text-align: left;">INFORME PENALES 2</button>
                </div>
            </div>
        @endif
        @if ($rol==3 || $rol==8 || $rol==9 ||$rol==10)
            <div class="row" style="padding-top: 20px;">
                <div class="col-sm-2">
                    <button onclick="InformeGeneral(3);" type="button" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> MOV</button>
                </div>
                <div class="col-sm-10">
                    <button onclick="InformeGeneral(3);" type="button" class="btn btn-primary" style="width: 100%;text-align: left;">INFORME MOVILIDAD</button>
                </div>
            </div>
        @endif
        @if ($rol==4 || $rol==8 || $rol==9 ||$rol==10)
            <div class="row" style="padding-top: 20px;">
                <div class="col-sm-2">
                    <button onclick="InformeGeneral(4);" type="button" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> JUZ</button>
                </div>
                <div class="col-sm-10">
                    <button onclick="InformeGeneral(4);" type="button" class="btn btn-primary" style="width: 100%;text-align: left;">INFORME JUZGADOS</button>
                </div>
            </div>
        @endif
        @if ($rol==5 || $rol==8 || $rol==9 ||$rol==10)
            <div class="row" style="padding-top: 20px;">
                <div class="col-sm-2">
                    <button onclick="InformeGeneral(5);" type="button" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> SEG</button>
                </div>
                <div class="col-sm-10">
                    <button onclick="InformeGeneral(5);" type="button" class="btn btn-primary" style="width: 100%;text-align: left;">INFORME SEGUNDA</button>
                </div>
            </div>
        @endif
        @if ($rol==9 ||$rol==10)
            <div class="row" style="padding-top: 20px;">
                <div class="col-sm-2">
                    <button onclick="InformeGeneral(6);" type="button" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> PMR</button>
                </div>
                <div class="col-sm-10">
                    <button onclick="InformeGeneral(6);" type="button" class="btn btn-primary" style="width: 100%;text-align: left;">INFORME PMR</button>
                </div>
            </div>
        @endif
        @if ($rol==9 ||$rol==10)
            <div class="row" style="padding-top: 20px;">
                <div class="col-sm-2">
                    <button onclick="InformeGeneral(7);" type="button" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> AE</button>
                </div>
                <div class="col-sm-10">
                    <button onclick="InformeGeneral(7);" type="button" class="btn btn-primary" style="width: 100%;text-align: left;">AGENCIAS ESPECIALES</button>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
@section('codigos')
    <!-- Códigos para Plan de Trabajo -->
    <script src="{{asset("assets/js/estadisticas/informes.js")}}"></script>
@endsection