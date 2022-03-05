var clicksMas = 0;

$(document).ready(function() {
    CargarDatos();
});

// Metodo que permite consultar mediante una peticion ajax la informacion de los planes de trabajo creados
function CargarDatos() {
    _POST('json', '/penales1/oficio/actuaciones', {}, function (result){
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
    for (var i = 0; i < datos.length; i++) {
        var columna = [];
        columna.push(datos[i]['id']);
        columna.push(datos[i]['txt_tipo_actuacion']);
        columna.push(datos[i]['txt_clase_diligencia']);
        columna.push(datos[i]['txt_estado_audiencia']);
        columna.push(datos[i]['txt_despacho_judicial']);
        columna.push(datos[i]['noticia_criminal']);
        columna.push(datos[i]['btn_acciones']);
        filas.push(columna);
    }
    $('#tablaDatos').DataTable({
        columns: [
            { title: "ID" },
            { title: "Tipo de intervención" },
            { title: "Clase de diligencia" },
            { title: "Estado de la audiencia" },
            { title: "Despacho judicial" },
            { title: "# Noticia criminal" },
            { title: "Detalle" }
        ],
        columnDefs: [
            { targets: 5, className: "text-center" }
        ],
        data: filas,
        language: { url: SpanishDT }
    });
}

function NuevaActuacion() {
    clicksMas = 0;
    _POST('html', '/penales1/oficio/modal', {}, function (result){
        $('#espacioModal').html(result);
    });
}

function Ver(id) {
    clicksMas = 0;
    var datos = {id: id};
    _POST('html', '/penales1/oficio/modal_ver', JSON.stringify(datos), function (result){
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
        $('#btnSi').css('border', 'none');
        $('#btnNo').css('border', '1px solid #dc3545');
        $('#paraLinea').removeClass('lineaD');
        $('#pegar').hide();
        $('#btnPega').hide();
        $('#btnAplica').hide();
    } else {
        $('#identifica_denunciado').val('Si');
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