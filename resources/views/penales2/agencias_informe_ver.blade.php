@extends("plantilla.modal")
@section('modalTitle')
INFORME AGENCIA ESPECIAL {{$informe->periodo_reportado}}
@endsection
@section('modalBtnsHeader')
@endsection
@section('modalBody')
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-info btn-block btn-sm" data-toggle="modal" data-target="#modalDatosAgencia"><i class="fas fa-balance-scale"></i>&nbsp;&nbsp; DATOS CONSTITUCIÓN AGENCIA ESPECIAL</button>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-4">
            <label class="minilabel">Fecha de informe</label>
        <input type="text" class="form-control" value="{{$informe->fecha_informe}}" disabled>
        </div>
        <div class="col-md-8">
            <label class="minilabel">Periodo reportado</label>
            <input type="text" class="form-control" value="{{$informe->periodo_reportado}}" disabled>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="minilabel">Tipo de víctima</label>
            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$informe->tipo_victima}}</textarea>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modalDenunciados"><i class="far fa-id-card"></i>&nbsp;&nbsp; Datos de la victima</button>
        </div>
    </div>
    <div class="row" style="padding-top: 18px;">
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modalDelito"><i class="fas fa-stamp"></i>&nbsp;&nbsp; ¿Corrigió delito?</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modalIndiciado"><i class="fas fa-user-lock"></i>&nbsp;&nbsp; ¿Indiciado identificado?</button>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="minilabel">Sintesis de los hechos</label>
            <textarea class="form-control" rows="3" disabled style="font-size: 12px; resize: none;">{{$agencia->sintesis}}</textarea>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="minilabel">Actuación procesal</label>
            <textarea class="form-control" rows="3" disabled style="font-size: 12px; resize: none;">{{$informe->actuacion_procesal}}</textarea>
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
                    @php echo $rdenunciados; @endphp
                </div>
            </div>
        </div>
    </div>


    <!-- ************************** Modal Delito ************************** -->
    <div class="modal fade" id="modalDelito" tabindex="-1" role="dialog" aria-labelledby="modalDelitoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" style="padding-bottom: 20px;">
                        <div class="col-md-12">
                            <button type="button" class="close" onclick="$('#modalDelito').modal('hide');">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="row" style="margin: 0px -10px 0px -10px;">
                        <div class="col-md-6">
                            <label class="minilabel">Delito</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$informe->nuevo_delito}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Despacho judicial</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$informe->nuevo_despacho}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ************************** Modal Indiciado ************************** -->
    <div class="modal fade" id="modalIndiciado" tabindex="-1" role="dialog" aria-labelledby="modalIndiciadoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" style="padding-bottom: 20px;">
                        <div class="col-md-12">
                            <button type="button" class="close" onclick="$('#modalIndiciado').modal('hide');">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="row" style="margin: 0px -10px 0px -10px;">
                        <div class="col-md-6">
                            <label class="minilabel">Nombre</label>
                            <textarea class="form-control" rows="1" disabled style="font-size: 12px; resize: none;">{{$informe->nombre_indiciado}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Identificación</label>
                            <textarea class="form-control" rows="1" disabled style="font-size: 12px; resize: none;">{{$informe->indentificacion_indiciado}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ************************** Modal Datos de la Agencia ************************** -->
    <div class="modal fade" id="modalDatosAgencia" tabindex="-1" role="dialog" aria-labelledby="modalDatosAgenciaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="minilabel">Número de agencia especial:</label>
                            <textarea class="form-control" rows="1" disabled style="font-size: 12px; resize: none;">{{sprintf("%03d", $agencia->numero_agencia_especial)}}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="minilabel">Fecha creación</label>
                            <textarea class="form-control" rows="1" disabled style="font-size: 12px; resize: none;">{{$agencia->fecha_creacion}}</textarea>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="close" onclick="$('#modalDatosAgencia').modal('hide');">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6">
                            <label class="minilabel" >Delegada asignada</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->delegada}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Nombre del ministerio público</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->nombre_ministerio}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6">
                            <label class="minilabel">No. noticia criminal</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->noticia_criminal}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Despacho judicial</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->despacho_judicial}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-6"> 
                            <label class="minilabel">Nombre unidad</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->nombre_unidad}}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="minilabel">Adecuación típica actual</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->adecuacion_tipica}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-12">
                            <label class="minilabel">Criterios de creación</label>
                            <textarea class="form-control" rows="2" disabled style="font-size: 12px; resize: none;">{{$agencia->criterio_creacion}}</textarea>
                        </div>
                    </div>
                    <div class="row top10">
                        <div class="col-md-12">
                            <label class="minilabel">Justificación</label>
                            <textarea class="form-control" rows="3" disabled style="font-size: 12px;">{{$agencia->justificacion}}</textarea>
                        </div>                        
                    </div>

                </div>
            </div>
        </div>
    </div>



@endsection
@section('modalFooter')
@endsection
@section('modalScripts')
<script type="text/javascript">
$('[data-toggle="tooltip"]').tooltip();
IniciarControlesModal();
</script>
@endsection