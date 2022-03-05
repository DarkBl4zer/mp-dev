@extends("plantilla.modal")
@section('modalTitle')
NUEVA INTERVENCIÓN DE PARTE
@endsection
@section('modalBtnsHeader')
    
@endsection
@section('modalBody')
<form action="{{route('penales2_parte_guardar')}}" id="formularioParte" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="sinproc" name="sinproc" value="0">
    <input type="hidden" id="act_sinproc" name="act_sinproc" value="">
    <input type="hidden" name="identifica_denunciado" value="No">
    <div class="row">
        <div class="col-md-2" style="padding: 0px 0px 0px 11px;">
            <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modalSinproc" style="margin: 1px 5px; height: 36px;">
                SINPROC
            </button>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Sinproc</label>
            <input type="text" class="form-control" id="txtSinproc" disabled/>
            <span id="MtxtSinproc" class="msjRequerido"></span>
        </div>
        <div class="col-md-4" style="padding: 0px 20px 0px 0px;">
            <button type="button" id="btnDatos" class="btn btn-secondary btn-sm btn-block" data-toggle="modal" data-target="#modalDatosBasicos" style="margin: 1px 5px; height: 36px;" disabled>
                Datos basicos peticionario(a)
            </button>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">Tipo de intervención</label>
            <select class="form-control" id="tipo_actuacion" name="tipo_actuacion" onchange="$('#M' + this.id).html('').hide();CambioTipoActuacion(this.value);" >
                @php echo $parametricas['actuacion']; @endphp
            </select>
            <span id="Mtipo_actuacion" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Clase de diligencia</label>
            <select class="form-control" id="clase_diligencia" name="clase_diligencia" onchange="$('#M' + this.id).html('').hide();">
            </select>
            <span id="Mclase_diligencia" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" id="row_estado_audiencia" style="display: none;">
        <div class="col-md-12">
            <label class="requerido minilabel">Estado audiencia</label>
            <select class="form-control" id="estado_audiencia" name="estado_audiencia" onchange="$('#M' + this.id).html('').hide();"> 
            </select>
            <span id="Mestado_audiencia" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">Criterio de intervención</label>
                <select class="form-control select2" id="criterio_intervencion" name="criterio_intervencion" onchange="$('#M' + this.id).html('').hide();">
                    @php echo $parametricas['criterios']; @endphp
                </select>
            <span id="Mcriterio_intervencion" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Despacho judicial</label>
            <select class="form-control select2" id="despacho_judicial" name="despacho_judicial" onchange="$('#M' + this.id).html('').hide();">
                @php echo $parametricas['despacho']; @endphp
            </select>
            <span id="Mdespacho_judicial" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">No. noticia criminal</label>
            <input type="text" class="form-control" id="noticia_criminal" name="noticia_criminal" autocomplete="off" maxlength="21" minlength="21" onkeyup="this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();" onblur="ValidarMinimo(this.id, 21);this.value = FiltrarCaracteres(this, 'numeros');$('#M' + this.id).html('').hide();" />
            <span id="Mnoticia_criminal" class="msjRequerido">Número incorrecto</span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Delito</label>
            <select class="form-control select2" id="delito" name="delito" onchange="$('#M' + this.id).html('').hide();">
                @php echo $parametricas['delito']; @endphp
            </select>
            <span id="Mdelito" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10" id="campoCordis">
        <div class="col-md-12">
            <label class="minilabel" >Número CORDIS</label>
            <input type="text" class="form-control" id="numero_cordis" name="numero_cordis" autocomplete="off" maxlength="13" minlength="7" onkeyup="this.value = FiltrarCaracteres(this, 'cordis');$('#M' + this.id).html('').hide();" onblur="ValidarMinimo(this.id, 7, true);" />
            <span id="Mnumero_cordis" class="msjRequerido">Número CORDIS incorrecto</span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-6">
            <label class="requerido minilabel">Fecha intervención</label>
            <div class="input-group date">
                <div class="input-group-prepend" onclick="$('#fecha_actuacion').click();" style="cursor: pointer;">
                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt" style="font-size: 20px;"></i></span>
                </div>
                <input type="text" class="form-control pull-right" id="fecha_actuacion" name="fecha_actuacion" autocomplete="off"  maxlength="10" minlength="10" onkeyup="this.value = FiltrarCaracteres(this, 'fechas');" onchange="$('#M' + this.id).html('').hide();">
            </div>
            <span id="Mfecha_actuacion" class="msjRequerido"></span>
        </div>
        <div class="col-md-6">
            <label class="requerido minilabel">Adjuntar documento</label>
            <div class="input-group">
                <input type="file" id="archivo" name="archivo" style="display: none;" onchange="ArchivoValido(this.id, 'pdf;jpg;png', 2);" accept=".pdf, .jpg, .png">
                <input type="text" class="form-control txtArchivo" id="txt_archivo" placeholder="Seleccione un archivo..." readonly onclick="$('#archivo').click();">
                <span class="input-group-btn">
                    <button class="btn btn-warning btn-danger btn-sm" type="button" style="margin: 1px 5px; height: 36px;" onclick="$('#archivo').val('');$('#txt_archivo').val('');$('#Marchivo').html('').hide();">Borrar</button>
                </span>
            </div>
            <span id="Marchivo" class="msjRequerido"></span>
        </div>
    </div>
    <div class="row top10">
        <div class="col-md-12">
            <label class="requerido minilabel">Observaciones</label>
            <textarea class="form-control" id="observaciones" rows="3" cols="10" maxlength="1000" onkeyup="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();" onblur="this.value = FiltrarCaracteres(this, 'textos', true);$('#M' + this.id).html('').hide();"></textarea>
            <input type="hidden" name="observaciones" id="Oobservaciones">
        </div>
        <div class="col-md-6"><span id="Mobservaciones" class="msjRequerido"></span></div>
        <div class="col-md-6 text-right" id="cont_observaciones" style="font-size: 11px; padding-top: 2px;"><i class="fas fa-align-left"></i>1000</div>
    </div>
</form>



<!--************************************** Modal SINPROC **************************************-->
<div class="modal fade" id="modalSinproc" tabindex="-1" role="dialog" aria-labelledby="modalSinprocLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="padding-bottom: 10px;">
                        <button type="button" class="close" onclick="$('#modalSinproc').modal('hide');">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <table class="table table-bordered" style="font-size: 13px;">
                    <thead>
                        <tr>
                            <th style="padding: 5px;">SINPROC</th>
                            <th style="padding: 5px;">TRAMITE</th>
                            <th style="width: 43px; padding: 5px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sinprocs as $item)
                            <tr>
                                <td style="padding: 5px;">{{$item->sinprocID}}</td>
                                <td style="padding: 5px;">{{$item->nombreTramite}}</td>
                                <td style="padding: 5px;"><button type="button" class="btn btn-success btn-sm" onclick="SSinproc({{$item->sinprocID}}, '{{$item->nombreTramite}}', '{{$item->sinprocID . ';' . $item->idTramite . ';' . $item->annoCreacionSinproc}}');"><i class="fas fa-check"></button></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!--************************************** Modal Datos Básicos **************************************-->
<div class="modal fade" id="modalDatosBasicos" tabindex="-1" role="dialog" aria-labelledby="modalDatosBasicosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <strong id="tituloSinproc"></strong>
                        <button type="button" class="close" onclick="$('#modalDatosBasicos').modal('hide');">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="row top10">
                    <div class="col-md-12">
                        <label class="minilabel">Observaciones</label>
                        <textarea class="form-control" rows="5" style="font-size: 12px; resize: none;" id="sinproc_observaciones" disabled></textarea>
                    </div>
                </div>
                <div class="row top10">
                    <div class="col-md-6">
                        <label class="minilabel">Nombre(s)</label>
                        <input style="font-size: 12px;" type="text" class="form-control" id="nombre" disabled/>
                    </div>
                    <div class="col-md-6">
                        <label class="minilabel">Apellido(s)</label>
                        <input style="font-size: 12px;" type="text" class="form-control" id="apellido" disabled/>
                    </div>
                </div>
                <div class="row top10">
                    <div class="col-md-6">
                        <label class="minilabel">Documento de identidad</label>
                        <input style="font-size: 12px;" type="text" class="form-control" id="documento_identidad" disabled/>
                    </div>
                    <div class="col-md-6">
                        <label class="minilabel">Dirección</label>
                        <input style="font-size: 12px;" type="text" class="form-control" id="direccion" disabled/>
                    </div>
                </div>
                <div class="row top10">
                    <div class="col-md-6">
                        <label class="minilabel">Teléfono</label>
                        <input style="font-size: 12px;" type="text" class="form-control" id="telefono" disabled/>
                    </div>
                    <div class="col-md-6">
                        <label class="minilabel">Correo Electrónico</label>
                        <input style="font-size: 12px;" type="text" class="form-control" id="correo_electronico" disabled/>
                    </div>
                </div>
                <div class="row top10">
                    <div class="col-md-6">
                        <label class="minilabel">Género</label>
                        <input style="font-size: 12px;" type="text" class="form-control" id="genero" disabled/>
                    </div>
                    <div class="col-md-6">
                        <label class="minilabel">Nacionalidad</label>
                        <input style="font-size: 12px;" type="text" class="form-control" id="nacionalidad" disabled/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('modalFooter')
<div class="col-md-6 text-right" id="btnRegistrar">
    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="RegistrarActuacion();"><span class="fa fa-save"> </span>&nbsp;&nbsp; REGISTRAR INTERVENCIÓN</button>
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