$(document).ready(function() {
    CargarDatos();
});

// Metodo que permite consultar mediante una peticion ajax la informacion de los planes de trabajo creados
function CargarDatos() {
    _POST('json', '/movilidad/oficio/actuaciones', {}, function (result){
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
        columna.push(datos[i]['txt_clase']);
        columna.push(datos[i]['numero']);
        columna.push(datos[i]['btn_acciones']);
        filas.push(columna);
    }
    $('#tablaDatos').DataTable({
        columns: [
            { title: "ID" },
            { title: "Tipo de intervención" },
            { title: "Clase de diligencia" },
            { title: "Estado de la audiencia" },
            { title: "Clase de contravención" },
            { title: "NÚMERO EXPEDIENTE" },
            { title: "Detalle" }
        ],
        data: filas,
        language: { url: SpanishDT }
    });
}

function NuevaActuacion() {
    clicksMas = 0;
    _POST('html', '/movilidad/oficio/modal', {}, function (result){
        $('#espacioModal').html(result);
    });
}

function Ver(id) {
    clicksMas = 0;
    var datos = {id: id};
    _POST('html', '/movilidad/oficio/modal_ver', JSON.stringify(datos), function (result){
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
    _POST('json', '/movilidad/oficio/cambio_tipo_actuacion', JSON.stringify(datos), function (result){
        $('#clase_diligencia').html(result.clase_diligencia);
        if (ta==18) {
            $('#estado_audiencia').html(result.estado_audiencia);
            $('#row_estado_audiencia').show();
        } else{
            $('#estado_audiencia').html('');
            $('#row_estado_audiencia').hide();
        }
        $('#clase_diligencia').select2();
    });
}

//Metodo que permite validar el formulario y luego hacer el submit al controller
function RegistrarActuacion(){
    var valida = true;
    var mover_a = '';
    //Campos requeridos no alternativos
    var campos = ['tipo_actuacion','clase_diligencia','clase','numero','fecha_actuacion','observaciones','tipo_documento','numero_documento','primer_nombre','primer_apellido'];
    for (let i = 0; i < campos.length; i++) {
        //Verifica si el campo esta enblanco o el select esta en seleccione datos
        if (!CampoValido(campos[i], 'Campo requerido.')) {
            mover_a = campos[i];
            valida = false;
        } else{
            if (campos[i] == 'numero') {
                if (!ValidarMinimo(campos[i], 8)) {
                    valida = false;
                    mover_a = campos[i];
                }
            }
        }
    }
    //Verifica si el select esta en seleccione datos del camino alternativo estado audiencia.
    var ta = $('#tipo_actuacion').val();
    if (ta==18) {
        if (!CampoValido('estado_audiencia', 'Campo requerido.')) {
            valida = false; 
            mover_a = 'estado_audiencia';
        }
    }
    if (valida) {
        $('#Oobservaciones').val(Base64.encode($('#observaciones').val()));
        if ($('#Marchivo').html() == "") {
            $('#formularioOficio').submit();
        }
    } else{
        if (mover_a == 'tipo_documento' || mover_a == 'numero_documento' || mover_a == 'primer_nombre' || mover_a == 'primer_apellido') {
            $('#modalDenunciados').modal('show');
        } else{
            $('#modalDenunciados').modal('hide');
        }
        $('#modalModal').animate({
            scrollTop: ($('#'+mover_a).offset().top - 40)
        },500);
    }
}