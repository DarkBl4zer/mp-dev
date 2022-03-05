$(document).ready(function() {
    CargarDatos();
});

// Metodo que permite consultar mediante una peticion ajax la informacion de los planes de trabajo creados
function CargarDatos() {
    _POST('json', '/juzgados/notificaciones/listas', {}, function (result){
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
        //columna.push(datos[i]['id']);
        columna.push(datos[i]['txt_unidad']);
        columna.push(datos[i]['cantidad']);
        columna.push(datos[i]['fechaCrea']);
        columna.push(datos[i]['btn_acciones']);
        filas.push(columna);
    }
    $('#tablaDatos').DataTable({
        columns: [
            /*{ title: "ID" },*/
            { title: "Unidad" },
            { title: "Cantidad" },
            { title: "Fecha creación" },
            { title: "Documento adjunto" }
        ],
        data: filas,
        language: { url: SpanishDT }
    });
}

function NuevaActuacion() {
    clicksMas = 0;
    _POST('html', '/juzgados/notificaciones/modal', {}, function (result){
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

//Metodo que permite validar el formulario y luego hacer el submit al controller
function RegistrarActuacion(){
    var valida = true;
    var mover_a = '';
    //Campos requeridos no alternativos
    var campos = ['unidad','cantidad'];
    for (let i = 0; i < campos.length; i++) {
        //Verifica si el campo esta enblanco o el select esta en seleccione datos
        if (!CampoValido(campos[i], 'Campo requerido.')) {
            mover_a = campos[i];
            valida = false;
        }
    }
    if (valida) {
        if ($('#Marchivo').html() == "") {
            $('#formularioEnteramientos').submit();
        }
    } else{
        $('#modalModal').animate({
            scrollTop: ($('#'+mover_a).offset().top - 40)
        },500);
    }
}