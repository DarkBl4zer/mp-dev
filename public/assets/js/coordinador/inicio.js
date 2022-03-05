$(document).ready(function() {
    CargarDatos();
});

// Metodo que permite consultar mediante una peticion ajax la informacion de los planes de trabajo creados
function CargarDatos() {
    _POST('json', '/coordinador/tabla', {}, function (result){
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
        columna.push(datos[i]['delegada']);
        columna.push(datos[i]['nombre_ministerio']);
        columna.push(datos[i]['despacho_judicial']);
        columna.push(datos[i]['justificacion']);
        columna.push(datos[i]['btn_acciones']);
        filas.push(columna);
    }
    var table = $('#tablaDatos').DataTable({
        columns: [
            { title: "Agencia especial" },
            { title: "Delegada" },
            { title: "Ministerio Público" },
            { title: "Despacho Judicial" },
            { title: "Justificación" },
            { title: "Acciones" }
        ],
        columnDefs: [
            { targets: 5, className: "text-center", width: "130px" }
        ],
        data: filas,
        language: { url: SpanishDT }
    });
    table.on('draw',function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
}


function NuevaActuacion() {
    $('#nombre_ministerio').html('');
    delete phpDelegada;
    delete phpMP;
    _POST('html', '/coordinador/modal', {}, function (result){
        $('#espacioModal').html(result);
    });
}

function IniciarControlesModal(tipo){
    $('.select2').select2();
    $('#modalModal').modal({backdrop: 'static', keyboard: false});
    if (tipo == 1) {
        CambioTipoActuacion(phpDelegada, phpMP);
    }
}

function RegistrarActuacion(){
    var valida = true;
    var mover_a = '';
    //Campos requeridos no alternativos
    var campos = ['numero_agencia_especial','fecha_creacion','delegada','nombre_ministerio','noticia_criminal','despacho_judicial','adecuacion_tipica','criterio_creacion', 'justificacion'];
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
    if (valida) {
        $('#Ojustificacion').val(Base64.encode($('#justificacion').val()));
        $('#formularioAgencia').submit();
    } 
}

function CambioTipoActuacion(ta, sl=false) {
    var datos = {ta: ta};
    _POST('json', '/coordinador/ministerio', JSON.stringify(datos), function (result){
        $('#nombre_ministerio').html(result.nombre_ministerio);
        if (sl != false) {
            $('#nombre_ministerio').val(sl);
        }
        $('#nombre_ministerio').select2();
    });
}

function unidad(){
    $('#Mdespacho_judicial').hide();
    var unidad = $("#despacho_judicial option:selected").text();
    $('#nombre_unidad').val(unidad.split('--')[1]);
}

function Editar(id){
    var datos = {id: id};
    _POST('html', '/coordinador/editar', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
    });
}

function Ver(idAE, idD){
    var datos = {idAE: idAE};
    _POST('html', '/penales'+idD+'/agencias/informes', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
        $('#btnRegistrar').html('');
    });
}

function Finalizar(idAE){
    $('#idAE').val(idAE);
    $('#modalFinalizar').modal({backdrop: 'static', keyboard: false});
}

function Fin(estado){
    $('#estado').val(estado);
    var valida = true;
    if (!CampoValido('justificacion_fin', 'Campo requerido.')) {
        valida = false;
    }
    if (valida) {
        $('#Ojustificacion_fin').val(Base64.encode($('#justificacion_fin').val()));
        $('#formularioFin').submit();
    }
}

function Historial(){
    var idAE = $('#idAE').val();
    var datos = {idAE: idAE, tipo: 'c'};
    _POST('html', '/coordinador/historial', JSON.stringify(datos), function (result){
        $('#bodyHistorial').html(result);
        $('#modalHistorial').modal({backdrop: 'static', keyboard: false});
    });
}