$(document).ready(function() {
    CargarDatos();
});

// Metodo que permite consultar mediante una peticion ajax la informacion de los planes de gestion finalizados
function CargarDatos(){
    _POST('json', '/gestion/lista', {}, function (result){
        if (result.length > 0) {
            LlenaTabla(result);
        } else {
            LimpiarTabla('tablaDatos');
            $("#noDatos").html('<p style="color: red">No se encontraron resultados.</p>');
        }
    });
}

function LlenaTabla(datos) {
    LimpiarTabla('tablaDatos');
    var filas = [];
    for (var i = 0; i < datos.length; i++) {
        var columna = [];
        columna.push(datos[i]['nombre']);
        columna.push(datos[i]['cantidad']);
        var btns = '<a href="/gestion/editar/' + datos[i]['id'] + '" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>';
        columna.push(btns);
        filas.push(columna);  
    }
    $('#tablaDatos').DataTable({
        columns: [
            { title: "Nombre de la lista" },
            { title: "Número de items" },
            { title: " " }
        ],
        columnDefs: [
            { targets: 1, width: "150px" },
            { targets: 2, orderable: false, width: "22px" }
        ],
        data: filas,
        language: { url: SpanishDT }
    });
}