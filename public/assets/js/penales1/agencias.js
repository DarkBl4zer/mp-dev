var clicksMas = 0;

$(document).ready(function() {
    CargarDatos();
});

// Metodo que permite consultar mediante una peticion ajax la informacion de los planes de trabajo creados
function CargarDatos() {
    _POST('json', '/penales1/agencias/tabla', {}, function (result){
        if (result.length > 0) {
            LlenaTabla(result);
        } else {
            LimpiarTabla('tablaDatos');
            $("#noDatos").html('<p style="color: red">No has registrado intervenciones de oficio.</p>');
        }
    });
}

// Metodo que permite llenar el control DataTable con los datos de la consulta ajax
function LlenaTabla(datos) {
    LimpiarTabla('tablaDatos');
    var filas = [];
    var spnotis = notis.split(';');
    for (var i = 0; i < datos.length; i++) {
        var btn_noti = "";
        for (let a = 0; a < spnotis.length; a++) {
            if (spnotis[a] == datos[i]['id']) {
                btn_noti = '<i class="fa fa-exclamation-circle noti-nivel2" aria-hidden="true"></i>';
            }
        }
        var columna = [];
        columna.push(btn_noti+datos[i]['numero_agencia_especial']);
        columna.push(datos[i]['nombre_ministerio']);
        columna.push(datos[i]['despacho_judicial']);
        columna.push(datos[i]['justificacion']);
        columna.push(datos[i]['dias_informe']);
        columna.push(datos[i]['btn_acciones']);
        filas.push(columna);
    }
    var table = $('#tablaDatos').DataTable({
        columns: [
            { title: "Agencia especial" },
            { title: "Ministerio Público" },
            { title: "Despacho Judicial" },
            { title: "Justificación" },
            { title: "Siguiente informe" },
            { title: "Acciones" }
        ],
        columnDefs: [
            { targets: 4, className: "text-center", width: "140px" },
            { targets: 5, className: "text-center", width: "140px" }
        ],
        data: filas,
        language: { url: SpanishDT }
    });
    table.on('draw',function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
}

function Int(id) {
    clicksMas = 0;
    var datos = {id: id};
    _POST('html', '/penales1/agencias/intervencion', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
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
    $('.select2').select2();
    $('#modalModal').modal({backdrop: 'static', keyboard: false});
    $('#fecha_informe').val(moment().format('DD/MM/YYYY'));
}

function CambioTipoActuacion(ta) {
    var datos = {ta: ta};
    _POST('json', '/penales1/oficio/cambio_tipo_actuacion', JSON.stringify(datos), function (result){
        $('#clase_diligencia').html(result.clase_diligencia);
        if (ta==1 || ta==6 || ta==9) {
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
    var campos = ['tipo_actuacion','clase_diligencia','criterio_intervencion','despacho_judicial','noticia_criminal','delito','fecha_actuacion','observaciones'];
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
    if (ta==1 || ta==6 || ta==9) {
        if (!CampoValido('estado_audiencia', 'Campo requerido.')) {
            valida = false; 
            mover_a = 'estado_audiencia';
        }
    }
    //Verifica si los campos esta enblanco o los select esta en seleccione datos del camino alternativo identifica denunciado
    if ($('#identifica_denunciado').val() == 'Si') {
        for (let i = 0; i < clicksMas; i++) {
            var arroba = i + 1;
            //Valida cantidad
            if (!CampoValido('cantidad_' + arroba, 'Requerido.')) {
                valida = false; 
                mover_a = 'paraLinea';
            }
            //Valida sexo
            if (!CampoValido('sexo_' + arroba, 'Requerido.')) {
                valida = false; 
                mover_a = 'paraLinea';
            }
            //Valida nacionalidad_
            if (!CampoValido('nacionalidad_' + arroba, 'Requerido.')) {
                valida = false; 
                mover_a = 'paraLinea';
            }
        }   
    }
    
    if (valida) {
        if ($('#identifica_denunciado').val() == 'No') {
            $('#pegar').html('');
        }
        $('#Oobservaciones').val(Base64.encode($('#observaciones').val()));
        if ($('#Marchivo').html() == "") {
            $('#formularioOficio').submit();
        }
    } else{
        if (mover_a == 'paraLinea') {
            $('#modalDenunciados').modal('show');
        } else{
            $('#modalDenunciados').modal('hide');
        }
        $('#modalModal').animate({
            scrollTop: ($('#'+mover_a).offset().top - 40)
        },500);
    }
}

function Identifica(tipo) {
    if (tipo == 'No') {
        $('#identifica_denunciado').val('No');
        $('#datos_victima').val('No');
        $('#btnSi').css('border', 'none');
        $('#btnNo').css('border', '1px solid #dc3545');
        $('#paraLinea').removeClass('lineaD');
        $('#pegar').hide();
        $('#btnPega').hide();
        $('#btnAplica').hide();
    } else {
        $('#identifica_denunciado').val('Si');
        $('#datos_victima').val('Si');
        $('#btnNo').css('border', 'none');
        $('#btnSi').css('border', '1px solid #4CAF50');
        $('#paraLinea').addClass('lineaD');
        $('#pegar').show();
        $('#btnPega').show();
        $('#btnAplica').show();
        if (clicksMas == 0) {
            AgregarMas();
        }
    }
}

function AgregarMas(){
    clicksMas++;
    var base = $('#copiar').html();
    const stripped = base.replace(/_@/g, '_'+clicksMas);
    $('#pegar').append(stripped);
    $('#clicksMas').val(clicksMas);
    if (clicksMas > 1) {
        var anterior = clicksMas - 1;
        $('#row_' + anterior).addClass('lineaD');
    }
	$('#nacionalidad_'+clicksMas).select2();
}

function AgregarMenos(){
    if (clicksMas > 1) {
        $('#row_' + clicksMas).remove();
        clicksMas--;
    }
    $('#row_' + clicksMas).removeClass('lineaD');
    $('#clicksMas').val(clicksMas);
}

function VerIntervenciones(id){
    $('#modalModal').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    var datos = {id: id};
    _POST('html', '/penales1/agencias/intervenciones', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
    });
}

function VerOficio(id) {
    clicksMas = 0;
    var datos = {id: id};
    _POST('html', '/penales1/oficio/modal_ver', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
    });
}

function Inf(id, bloqueo){
    clicksMas = 0;
    var datos = {id: id};
    _POST('html', '/penales1/agencias/informe', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
        if (bloqueo) {
            $('#btnRegistrar').html('');
            $('#formulario').hide();
        }
    });
}

function CorregirDelito(tipo){
    if (tipo == 'No') {
        $('#corregir_delito').val('No');
        $('#btnDelSi').css('border', 'none');
        $('#btnDelNo').css('border', '1px solid #dc3545');
        $('#Mnuevo_delito').html('').hide();
        $('#Mnuevo_despacho').html('').hide();
        $('#nuevo_delito').val('');
        $('#nuevo_despacho').val('');
        $('#nuevo_delito').select2().trigger('change');
        $('#nuevo_despacho').select2().trigger('change');
        $('#rowDelito').hide();
    } else {
        $('#corregir_delito').val('Si');
        $('#btnDelNo').css('border', 'none');
        $('#btnDelSi').css('border', '1px solid #4CAF50');
        $('#rowDelito').show();
    }
}

function ConoceIndiciado(tipo){
    if (tipo == 'No') {
        $('#dato_indiciado').val('No');
        $('#btnIndSi').css('border', 'none');
        $('#btnIndNo').css('border', '1px solid #dc3545');
        $('#Mnombre_indiciado').html('').hide();
        $('#Mindentificacion_indiciado').html('').hide();
        $('#nombre_indiciado').val('');
        $('#indentificacion_indiciado').val('');
        $('#rowIndiciado').hide();
    } else {
        $('#dato_indiciado').val('Si');
        $('#btnIndNo').css('border', 'none');
        $('#btnIndSi').css('border', '1px solid #4CAF50');
        $('#rowIndiciado').show();
    }
}

function FinalizarAE(tipo){
    if (tipo == 'No') {
        $('#fin_ae').val('No');
        $('#btnFinSi').css('border', 'none');
        $('#btnFinNo').css('border', '1px solid #dc3545');
        $('#Mjustificacion').html('').hide();
        $('#justificacion').val('');
        $('#rowFin').hide();
    } else {
        $('#fin_ae').val('Si');
        $('#btnFinNo').css('border', 'none');
        $('#btnFinSi').css('border', '1px solid #4CAF50');
        $('#rowFin').show();
    }
}

function RegistrarInforme(){
    var valida = true;
    var mover_a = '';
    //Campos requeridos no alternativos
    var campos = ['fecha_informe','periodo_reportado','tipo_victima','sintesis','actuacion_procesal'];
    if ($('#corregir_delito').val() == 'Si') {
        campos.push('nuevo_delito', 'nuevo_despacho');
    }
    if ($('#dato_indiciado').val() == 'Si') {
        campos.push('nombre_indiciado', 'indentificacion_indiciado');
    }
    if ($('#fin_ae').val() == 'Si') {
        campos.push('justificacion');
    }
    for (let i = 0; i < campos.length; i++) {
        //Verifica si el campo esta enblanco o el select esta en seleccione datos
        if (!CampoValido(campos[i], 'Campo requerido.')) {
            mover_a = campos[i];
            valida = false;
        }
    }
    //Verifica si los campos esta enblanco o los select esta en seleccione datos del camino alternativo identifica denunciado
    if ($('#datos_victima').val() == 'Si') {
        for (let i = 0; i < clicksMas; i++) {
            var arroba = i + 1;
            //Valida nombre
            if (!CampoValido('nombre_' + arroba, 'Requerido.')) {
                valida = false; 
                mover_a = 'paraLinea';
            }
            //Valida apellido
            if (!CampoValido('apellido_' + arroba, 'Requerido.')) {
                valida = false; 
                mover_a = 'paraLinea';
            }
            //Valida sexo
            if (!CampoValido('sexo_' + arroba, 'Requerido.')) {
                valida = false; 
                mover_a = 'paraLinea';
            }
            //Valida nacionalidad_
            if (!CampoValido('nacionalidad_' + arroba, 'Requerido.')) {
                valida = false; 
                mover_a = 'paraLinea';
            }
        }   
    }
    
    if (valida) {
        if ($('#datos_victima').val() == 'No') {
            $('#pegar').html('');
        }
        $('#Osintesis').val(Base64.encode($('#sintesis').val()));
        $('#Oactuacion_procesal').val(Base64.encode($('#actuacion_procesal').val()));
        $('#Ojustificacion').val(Base64.encode($('#justificacion').val()));
        $('#formularioInforme').submit();
    } else{
        if (mover_a == 'paraLinea') {
            $('#modalDenunciados').modal('show');
        } else{
            $('#modalDenunciados').modal('hide');
        }
        if (mover_a == 'nuevo_delito' || mover_a == 'nuevo_despacho') {
            $('#modalDelito').modal('show');
        } else{
            $('#modalDelito').modal('hide');
        }
        if (mover_a == 'nombre_indiciado' || mover_a == 'indentificacion_indiciado') {
            $('#modalIndiciado').modal('show');
        } else{
            $('#modalIndiciado').modal('hide');
        }
        if (mover_a == 'justificacion') {
            $('#modalFinalizar').modal('show');
        } else{
            $('#modalFinalizar').modal('hide');
        }
        $('#modalModal').animate({
            scrollTop: ($('#'+mover_a).offset().top - 40)
        },500);
    }
}

function VerInformes(idAE){
    $('#modalModal').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    var datos = {idAE: idAE};
    _POST('html', '/penales1/agencias/informes', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
    });
}

function Historial(idAE){
    var datos = {idAE: idAE, tipo: 'p'};
    _POST('html', '/coordinador/historial', JSON.stringify(datos), function (result){
        $('#bodyHistorial').html(result);
        $('#modalHistorial').modal({backdrop: 'static', keyboard: false});
    });
}

function Ver(idAE, idD){
    var datos = {idAE: idAE};
    _POST('html', '/penales'+idD+'/agencias/informes', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
        $('#btnRegistrar').html('');
    });
}