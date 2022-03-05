var table = null;
var texto = 'INFORME DETALLE PENALES1 - ' + nombre_actuacion;

$(document).ready(function() {
    InformeDetalle();
    $('#titulo_informe').html(texto);
});

function InformeDetalle(){
    var datos = {delegada: delegada, tipo: tipo, actuacion: actuacion};
    _POST('json', '/estadisticas/informe/detalle1_datos', JSON.stringify(datos), function (result){
        console.log(result);
        if (result.length > 0) {
            $('#rowExport').show();
            $("#tablaDatos").show();
            LlenaTabla1(result);
        } else {
            LimpiarTabla('tablaDatos');
            $('#rowExport').hide();
            $("#tablaDatos").hide();
            $("#noDatos").html('<p style="color: red">No se encontraron resultados.</p>');
        }
    });
}

function LlenaTabla1(datos) {
    LimpiarTabla('tablaDatos');
    var filas = [];
    for (var i = 0; i < datos.length; i++) {
        var columna = [];
        columna.push(datos[i]['id']);
        columna.push(datos[i]['fecha_actuacion']);
        columna.push(datos[i]['tipo_formulario']);
        columna.push(datos[i]['sinproc'] == null ? 'N/A' : datos[i]['sinproc']);
        columna.push(datos[i]['act_sinproc'] == null ? 'N/A' : datos[i]['act_sinproc']);
        columna.push(datos[i]['identifica_denunciado'] == null ? 'N/A' : datos[i]['identifica_denunciado']);
        if (rol > 5) {
            columna.push(datos[i]['datos_denunciados'] == '<ul></ul>' ? 'N/A' : datos[i]['datos_denunciados']);
        }
        columna.push(datos[i]['tipo_actuacion'] == null ? 'N/A' : datos[i]['tipo_actuacion']);
        columna.push(datos[i]['clase_diligencia'] == null ? 'N/A' : datos[i]['clase_diligencia']);
        columna.push(datos[i]['estado_audiencia'] == null ? 'N/A' : datos[i]['estado_audiencia']);
        columna.push(datos[i]['criterio_intervencion'] == null ? 'N/A' : datos[i]['criterio_intervencion']);
        columna.push(datos[i]['despacho_judicial'] == null ? 'N/A' : datos[i]['despacho_judicial']);
        columna.push(datos[i]['noticia_criminal'] == null ? 'N/A' : datos[i]['noticia_criminal']);
        columna.push(datos[i]['delito'] == null ? 'N/A' : datos[i]['delito']);
        columna.push(datos[i]['numero_cordis'] == null ? 'N/A' : datos[i]['numero_cordis']);
        columna.push(datos[i]['observaciones'] == null ? 'N/A' : datos[i]['observaciones']);
        columna.push(datos[i]['link_archivo'] == null ? 'N/A' : datos[i]['link_archivo']);
        if (rol > 5) {
            columna.push(datos[i]['usuario_crea']);
            columna.push(datos[i]['cc_usuario_crea']);   
        }
        columna.push(datos[i]['fecha_crea']);
        filas.push(columna);
    }
    var titulo = texto + '    ' + DDMMYYYY(new Date());
    var archivo = 'INFORME_DETALLE_PENALES1_' +  DDMMYYYY(new Date()).replace(/\//g, "-");
    var col = [];
    if (rol > 5) {
        col = [
            { targets: 6, width: '400px' },
            { targets: 11, width: '500px' },
            { targets: 15, width: '800px' },
            { targets: 17, width: '260px' }
        ]
    } else {
        col = [
            { targets: 4, visible: false },
            { targets: 10, width: '500px' },
            { targets: 14, width: '800px' }
        ]
    }
    table = $('#tablaDatos').DataTable({
        paging: true,
        info: false,
        columnDefs: col,
        data: filas,
        dom: 'Bfrtp',
        buttons: [{
            extend: 'excelHtml5', 
            title: titulo, 
            filename: archivo,
            exportOptions: {columns: ':visible'}
        }],
        language: { url: SpanishDT }
    });
}

function FiltrarColumna(columna, valor){
    table.columns(columna).search(valor).draw();
}