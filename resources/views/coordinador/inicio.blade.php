@extends("plantilla.base")
@section('titulo')
COORDINADOR
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
        <strong>COORDINADOR</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                <button onclick="NuevaActuacion();" class="btn btn-success btn-block btn-sm"><span class="fa fa-plus-circle"> </span>&nbsp;&nbsp; CONSTITUCIÓN AGENCIA ESPECIAL</button>
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
<div id="espacioModal"></div>

<!-- ************************** Modal Finalizar ************************** -->
<div class="modal fade" id="modalFinalizar" tabindex="-1" role="dialog" aria-labelledby="modalFinalizarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border: solid 1px #17a2b8;">
            <div class="modal-body">
                <div class="row" style="padding-bottom: 20px;">
                    <div class="col-md-6">
                        <button type="button" title="Historial justificaciones" class="btn btn-info" onclick="Historial();">
                            <i class="fas fa-history"></i>
                        </button>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-danger" onclick="$('#modalFinalizar').modal('hide');">
                            <span class="fas fa-times"></span>
                        </button>
                    </div>
                </div>
                <div class="row" id="rowFin" style="margin: 0px -10px 0px -10px;">
                    <div class="col-md-12">
                        <form action="{{route('coordinador_finalizar_guardar')}}" id="formularioFin" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="requerido minilabel">Justificación</label>
                            <textarea class="form-control" id="justificacion_fin" rows="3" cols="10" maxlength="1000" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();" onpaste="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();"></textarea>
                            <input type="hidden" name="justificacion_fin" id="Ojustificacion_fin">
                            <input type="hidden" name="estado" id="estado" value="2">
                            <input type="hidden" name="idAE" id="idAE" value="0">
                        </form>
                    </div>
                    <div class="col-md-6"><span id="Mjustificacion_fin" class="msjRequerido"></span></div>
                    <div class="col-md-6 text-right" id="cont_justificacion_fin" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
                </div>
                <div class="row top10">
                    <div class="col-md-6 text-right" id="btnRegistrar">
                        <button type="button" class="btn btn-primary btn-block btn-sm" onclick="Fin(4);"><i class="far fa-calendar-check"></i>&nbsp;&nbsp; APROBAR FINALIZACIÓN</button>
                    </div>
                    <div class="col-md-6 text-left">
                        <button type="button" class="btn btn-danger btn-block btn-sm" onclick="Fin(2);"><i class="far fa-calendar-times"></i>&nbsp;&nbsp; RECHAZAR FINALIZACIÓN</button>
                    </div>
                </div>
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
    <script src="{{asset("assets/js/coordinador/inicio.js")}}"></script>
@endsection