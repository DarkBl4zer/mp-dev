@extends("plantilla.base")
@section('titulo')
EDITAR LISTA {{$lista}}
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
        <strong>EDITAR LISTA {{$lista}}</strong>
    </div>
    <div class="card-body">
        @if ($id != 13)
            <div class="row">
                <div class="col-sm-3">
                    <button onclick="AgregarItem();" class="btn btn-success btn-block btn-sm"><span class="fa fa-plus-circle"> </span>&nbsp;&nbsp; AGREGAR ITEM</button>
                </div>
            </div>
        @endif
        <div class="row top10">
            <div class="col-sm-12">
                <table id="tablaDatos" class="table table-bordered table-striped" style="width: 100%; font-size: 13px;">
                </table>
                <div id="noDatos" class="col-md-12 text-center"></div>
            </div>
        </div>
        <div class="row top10">
            <div class="col-sm-12 text-center">
                <a href="{{route('gestion')}}" class="btn btn-primary btn-block btn-sm"><i class="fas fa-undo-alt"></i>&nbsp;&nbsp; REGRESAR</a>
            </div>
        </div>
    </div>
</div>


<!-- Modal Editar-->
<div class="modal fade" id="modalEditar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{route('gestion_lista_guardar')}}" id="formCrearEditar" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="idLista" name="idLista">
                    <input type="hidden" id="idItem" name="idItem">
                    <div class="row top10">
                        <div class="col-sm-12" id="pegar">
                            <label class="requerido minilabel" id="nombreValorItem">Valor del item</label>
                            <input type="text" class="form-control" id="valor" name="valor" autocomplete="off" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();">
                            <span id="Mvalor" class="msjRequerido"></span>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-sm-12">
                            <label class="requerido minilabel">Nombre del item</label>
                            <textarea id="nombre" name="nombre" class="form-control" rows="3" style="resize: none;" maxlength="255" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).hide();"></textarea>
                        </div>
                        <div class="col-md-6"><span id="Mnombre" class="msjRequerido"></span></div>
                        <div class="col-md-6 text-right" id="cont_nombre" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>255</div>
                    </div>
                    <div class="row top10" id="rowTipoMp" style="display:none;">
                        <div class="col-sm-12">
                            <label class="requerido minilabel">Tipo ministerio público</label>
                            <select class="form-control" id="id_tipo_mp" name="id_tipo_mp" onchange="$('#M' + this.id).html('').hide(); ActuacionesMP(this.value, 0);">
                                @php echo $tipoMp; @endphp
                            </select>
                            <span id="Mid_tipo_mp" class="msjRequerido"></span>
                        </div>
                    </div>
                    <div class="row top10" id="rowActuacion" style="display:none;">
                        <div class="col-sm-12">
                            <label class="requerido minilabel">Actuación</label>
                            <select class="form-control" id="id_actuacion" name="id_actuacion" onchange="$('#M' + this.id).html('').hide();">
                            </select>
                            <span id="Mid_actuacion" class="msjRequerido"></span>
                        </div>
                    </div>
                    <div class="row top10" id="rowCodigo" style="display:none;">
                        <div class="col-sm-12">
                            <label class="requerido minilabel">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" autocomplete="off" onkeyup="this.value = FiltrarCaracteres(this, 'cordis');$('#M' + this.id).html('').hide();">
                            <span id="Mcodigo" class="msjRequerido"></span>
                        </div>
                    </div>
                    <div class="row top10" id="rowRoles" style="display:none;">
                        <div class="col-sm-12">
                            <label class="requerido minilabel">Rol</label>
                            <select class="form-control" id="id_rol" name="id_rol" onchange="$('#M' + this.id).html('').hide();">
                                @php echo $roles; @endphp
                            </select>
                            <span id="Mid_rol" class="msjRequerido"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-success btn-block btn-sm" onclick="ValidarFormulario();"><span class="fa fa-save"> </span>&nbsp;&nbsp; ACTUALIZAR</button>
                </div>
                <div class="col-md-6 text-left">
                    <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal"><span class="fa fa-window-close"> </span>&nbsp;&nbsp; CANCELAR</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="copiar" style="display:none;">
    <label class="requerido minilabel">Valor del item</label>
    <div class="input-group date">
        <div class="input-group-prepend" onclick="$('#valor').focus();" style="cursor: pointer;">
            <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt" style="font-size: 20px;"></i></span>
        </div>
        <input type="text" class="form-control pull-right" id="valor" name="valor" autocomplete="off"  maxlength="10" minlength="10" onkeyup="this.value = FiltrarCaracteres(this, 'fechas');" onchange="$('#M' + this.id).html('').hide();">
    </div>
    <span id="Mvalor" class="msjRequerido"></span>
</div>

@endsection
@section('codigos')
<script type="text/javascript">
var idLista = {{$id}};
var masItem = "{{$masItem}}";
</script>
    <!-- Códigos para Plan de Trabajo -->
    <script src="{{asset("assets/js/gestion/editar.js")}}"></script>
@endsection