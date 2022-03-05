var checaUsuario = false;
var envioExterno = false;
var arr_para_sp = [];

$(document).ready(function() {
    CargarDatos();
});

// Metodo que permite consultar mediante una peticion ajax la informacion de los planes de trabajo creados
function CargarDatos() {
    _POST('json', '/penales2/parte/actuaciones', {}, function (result){
        if (result.length > 0) {
            LlenaTabla(result);
        } else {
            LimpiarTabla('tablaDatos');
            $("#noDatos").html('<p style="color: red">No has registrado intervenciones de parte.</p>');
        }
    });
}

// Metodo que permite llenar el control DataTable con los datos de la consulta ajax
function LlenaTabla(datos) {
    LimpiarTabla('tablaDatos');
    var filas = [];
    for (var i = 0; i < datos.length; i++) {
        var para_sp = [];
        para_sp.push(datos[i]['id']);
        para_sp.push(datos[i]['txt_actuacion_sinproc']);
        arr_para_sp.push(para_sp);
        var columna = [];
        columna.push(datos[i]['id']);
        columna.push(datos[i]['txt_tipo_actuacion']);
        columna.push(datos[i]['txt_clase_diligencia']);
        columna.push(datos[i]['txt_estado_audiencia']);
        columna.push(datos[i]['txt_despacho_judicial']);
        columna.push(datos[i]['btn_acciones']);
        filas.push(columna);
    }
    var table = $('#tablaDatos').DataTable({
        columns: [
            { title: "ID" },
            { title: "Tipo de intervención" },
            { title: "Clase de diligencia" },
            { title: "Estado de la audiencia" },
            { title: "Despacho judicial" },
            { title: "Acciones" }
        ],
        columnDefs: [
            { targets: 5, className: "text-center", width: "180px" }
        ],
        data: filas,
        language: { url: SpanishDT }
    });
    table.on('draw',function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
}

function NuevaActuacion() {
    _POST('html', '/penales2/parte/modal', {}, function (result){
        $('#espacioModal').html(result);
    });
}

function Ver(id) {
    var datos = {id: id};
    _POST('html', '/penales2/parte/modal_ver', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
    });
}

function modalHistorico(tk) {
    var datos = {tk: tk};
    _POST('html', '/wsinproc/sinproc_modal_hist', JSON.stringify(datos), function (result){
        $('#respuestaDetalle').html(result);
        $('#formularioActuacion').hide();
        $('#contenidoVer').hide();
        $('#btnRegistrar').html('');
    });
}

function Act(idAt, tk) {
    var desc_sinproc = "";
    for (let index = 0; index < arr_para_sp.length; index++) {
        if (arr_para_sp[index][0] == idAt) {
            desc_sinproc = arr_para_sp[index][1];
        }
    }
    var datos = {tk: tk};
    _POST('html', '/wsinproc/sinproc_modal_act', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
        var url = $('#urlBack').val();
        $('#urlBack').val(url+'2/');
        $('#descripcion').val(desc_sinproc);
        $('#descripcion').attr('readonly', true);
    });
}

function Rem(tk) {
    var datos = {tk: tk};
    _POST('html', '/wsinproc/sinproc_modal_rem', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
        var url = $('#urlBack').val();
        $('#urlBack').val(url+'2/');
    });
}

function Arc(tk) {
    var datos = {tk: tk};
    _POST('html', '/wsinproc/sinproc_modal_arc', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
        var url = $('#urlBack').val();
        $('#urlBack').val(url+'2/');
    });
}

function IniciarControlesModal(){
    $('#fecha_actuacion').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        opens: 'right',
        drops: 'up',
        maxDate: moment(),
        minDate: moment(primerDia()),
        locale: SpanishDP,
        isInvalidDate: function(date) {return EsUnDiaValido(date);}
    });
    $('#fecha_actuacion').val('');
    $('#fecha_gestion').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        opens: 'right',
        drops: 'down',
        maxDate: moment(),
        minDate: moment(primerDia()),
        locale: SpanishDP,
        isInvalidDate: function(date) {return EsUnDiaValido(date);}
    });
    $('#fecha_gestion').val('');
    $('.select2').select2();
    $('#modalModal').modal({backdrop: 'static', keyboard: false});
}

function SSinproc(sinproc, nombre, tk){
    var nombreItem = sinproc + ' - ' + nombre;
    $('#txtSinproc').val(nombreItem);
    $('#MtxtSinproc').hide();
    $('#sinproc').val(sinproc);
    $('#act_sinproc').val(' - ' + nombre + '||' + tk);
    $('#btnDatos').attr('disabled', false);
    $('#btnDatos').css({"color": "#fff", "background-color": "#003e65", "border-color": "#003e65"});
    $('#modalSinproc').modal('hide');
    var datos = {tk: tk};
    _POST('json', '/wsinproc/sinproc_detalle', JSON.stringify(datos), function (result){
        $('#sinproc_observaciones').val(result.observaciones.replace(/<br \/>/g, ''));
        $('#nombre').val(result.nombres);
        $('#apellido').val(result.apelllidos);
        $('#documento_identidad').val(result.documento);
        $('#direccion').val(result.direccion);
        $('#telefono').val(result.telefonos);
        $('#correo_electronico').val(result.email);
        $('#genero').val(result.genero);
        $('#nacionalidad').val(result.nacionalidad);
        $('#tituloSinproc').html('SINPROC: ' + nombreItem);
    });
}

function CambioTipoActuacion(ta) {
    var datos = {ta: ta};
    _POST('json', '/penales2/oficio/cambio_tipo_actuacion', JSON.stringify(datos), function (result){
        $('#clase_diligencia').html(result.clase_diligencia);
        if (ta==13 || ta==9) {
            $('#estado_audiencia').html(result.estado_audiencia);
            $('#row_estado_audiencia').show();
            $('#campoCordis').hide();
        } else{
            $('#estado_audiencia').html('');
            $('#row_estado_audiencia').hide();
            $('#campoCordis').show();
        }
        $('#clase_diligencia').select2();
    });
}

//Metodo que permite validar el formulario y luego hacer el submit al controller
function RegistrarActuacion(){
    var valida = true;
    var mover_a = '';
    //Campos requeridos no alternativos
    var campos = ['tipo_actuacion','clase_diligencia','criterio_intervencion','despacho_judicial','noticia_criminal','delito','fecha_actuacion','archivo','observaciones','txtSinproc'];
    for (let i = 0; i < campos.length; i++) {
        //Verifica si el campo esta enblanco o el select esta en seleccione datos
        if (!CampoValido(campos[i], 'Campo requerido.')) {
            mover_a = campos[i];
            valida = false;
        } else{
            if (campos[i] == 'noticia_criminal') {
                if (!ValidarMinimo(campos[i], 21)) {
                    valida = false;
                    mover_a = campos[i];
                }
            }
        }
    }
    var cordis = $('#numero_cordis').val();
    if (cordis.length > 0) {
        if (!ValidarMinimo('numero_cordis', 7)) {
            valida = false;
            mover_a = 'numero_cordis';
        }
    }
    //Verifica si el select esta en seleccione datos del camino alternativo estado audiencia.
    var ta = $('#tipo_actuacion').val();
    if (ta==13 || ta==9) {
        if (!CampoValido('estado_audiencia', 'Campo requerido.')) {
            valida = false; 
            mover_a = 'estado_audiencia';
        }
    }
    
    if (valida) {
        $('#Oobservaciones').val(Base64.encode($('#observaciones').val()));
        $('#formularioParte').submit();
    } else{
        $('#modalModal').animate({
            scrollTop: ($('#'+mover_a).offset().top - 40)
        },500);
    }
}

//Metodo que permite validar el formulario y luego hacer el submit al controller para guardar la actuacion en sinproc
function RegistrarActuacionSinproc(){
    var valida = true;
    var mover_a = '';
    //Campos requeridos no alternativos
    //var campos = ['tipo_actuacion','fecha_gestion','descripcion','archivo1','archivo2','archivo3'];
    var campos = ['tipo_gestion','fecha_gestion','descripcion'];
    for (let i = 0; i < campos.length; i++) {
        //Verifica si el campo esta enblanco o el select esta en seleccione datos
        if (!CampoValido(campos[i], 'Campo requerido.')) {
            mover_a = campos[i];
            valida = false;
        }
    }    
    if (valida) {
        var datos = {sinproc: $('#sinproc').val()};
        _POST('html', '/penales2/parte/guardar_act_sinproc', JSON.stringify(datos), function (result){
            $('#formularioActuacion').submit();
        });
    } else{
        $('#modalModal').animate({
            scrollTop: ($('#'+mover_a).offset().top - 40)
        },500);
    }
}

//Metodo que permite validar el formulario y luego hacer el submit al controller para guardar la remision en sinproc
function RegistrarRemisionSinproc(){
    var valida = true;
    var mover_a = '';
    //Campos requeridos no alternativos
    if (checaUsuario) {
        var campos = ['dep_remision','susuario','informacion'];
    } else {
        var campos = ['dep_remision','informacion'];
    }
    for (let i = 0; i < campos.length; i++) {
        //Verifica si el campo esta enblanco o el select esta en seleccione datos
        if (!CampoValido(campos[i], 'Campo requerido.')) {
            mover_a = campos[i];
            valida = false;
        }
    }    
    if (valida) {
        $('#formularioRemision').submit();
    } else{
        $('#modalModal').animate({
            scrollTop: ($('#'+mover_a).offset().top - 40)
        },500);
    }
}

function EnviarUsuario(dependencia){
    if (phpDelegada == dependencia) {
        $('#rowSUsuario').show();
        checaUsuario = true;
    } else{
        checaUsuario = false;
        $('#rowSUsuario').hide();
        var datos = {idD: dependencia};
        _POST('html', '/wsinproc/sinproc_jefe_delegada', JSON.stringify(datos), function (result){
            $('#remitir_a').val(result);
        });
    }
}

function CambioRemitirEntidad(valor){
    if (valor == 1) {
        $('#rowEntExterna').show();
        $('#rowCordis').show();
        $('#rowArchivoCordis').show();
        envioExterno = true;
    } else {
        $('#rowEntExterna').hide();
        $('#rowCordis').hide();
        $('#rowArchivoCordis').hide();
        envioExterno = false;
    }
}

//Metodo que permite validar el formulario y luego hacer el submit al controller para guardar el archivo en sinproc
function RegistrarArchivoSinproc(){
    var valida = true;
    var mover_a = '';
    //Campos requeridos no alternativos
    var campos = ['rem_externa','informacion','tipo_gestion','materializado'];
    if (envioExterno) {
        campos.push('ent_externa', 'numero_cordis', 'archivo');
    }
    if (phpClasificacionPQS != 0) {
        campos.push('num_copias');
    }
    if (phpHabilitaPMR == 1) {
        campos.push('pmr');
    }
    for (let i = 0; i < campos.length; i++) {
        //Verifica si el campo esta enblanco o el select esta en seleccione datos
        if (!CampoValido(campos[i], 'Campo requerido.')) {
            mover_a = campos[i];
            valida = false;
        }
    }    
    if (valida) {
        $('#formularioArchivo').submit();
    } else{
        $('#modalModal').animate({
            scrollTop: ($('#'+mover_a).offset().top - 40)
        },500);
    }
}