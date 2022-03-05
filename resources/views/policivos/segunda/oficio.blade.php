@extends("plantilla.base")
@section('titulo')
POLICIVOS / SEGUNDA - OFICIO
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
        <strong>POLICIVOS / SEGUNDA - OFICIO</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <button onclick="NuevaActuacion();" class="btn btn-success btn-block btn-sm"><span class="fa fa-plus-circle"> </span>&nbsp;&nbsp; INTERVENCIÓN OFICIO</button>
            </div>
        </div>
        <div class="row top10">
            <div class="col-sm-12">
                <table id="tablaDatos" class="table table-bordered table-striped" style="width: 100%; font-size: 13px;">
                </table>
                <div id="noDatos" class="col-md-12 text-center"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('codigos')
<script type="text/javascript">
@php echo $festivos; @endphp
</script>
    <!-- Códigos para Plan de Trabajo -->
    <script src="{{asset("assets/js/policivos/segunda/oficio.js")}}"></script>
@endsection