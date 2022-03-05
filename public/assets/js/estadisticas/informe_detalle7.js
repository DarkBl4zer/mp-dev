var table = null;
var texto = 'INFORME DETALLE AGENCIAS ESPECIALES - ' + nombre_actuacion;

$(document).ready(function() {
    InformeDetalle();
    $('#titulo_informe').html(texto);
});

function InformeDetalle(){
    var datos = {delegada: delegada, tipo: tipo, actuacion: actuacion};
    _POST('json', '/estadisticas/informe/detalle7_datos', JSON.stringify(datos), function (result){
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
        columna.push(datos[i]['numero_agencia_especial'] == null ? 'N/A' : datos[i]['numero_agencia_especial']);
        columna.push(datos[i]['fecha_creacion'] == null ? 'N/A' : datos[i]['fecha_creacion']);
        columna.push(datos[i]['delegada'] == null ? 'N/A' : datos[i]['delegada']);
        columna.push(datos[i]['nombre_ministerio'] == null ? 'N/A' : datos[i]['nombre_ministerio']);
        columna.push(datos[i]['noticia_criminal'] == null ? 'N/A' : datos[i]['noticia_criminal']);
        columna.push(datos[i]['despacho_judicial'] == null ? 'N/A' : datos[i]['despacho_judicial']);
        columna.push(datos[i]['nombre_unidad'] == null ? 'N/A' : datos[i]['nombre_unidad']);
        columna.push(datos[i]['adecuacion_tipica'] == null ? 'N/A' : datos[i]['adecuacion_tipica']);
        columna.push(datos[i]['criterio_creacion'] == null ? 'N/A' : datos[i]['criterio_creacion']);
        columna.push(datos[i]['justificacion'] == null ? 'N/A' : datos[i]['justificacion']);
        columna.push(datos[i]['sintesis'] == null ? 'N/A' : datos[i]['sintesis']);
        columna.push(datos[i]['actuacion_procesal'] == null ? 'N/A' : datos[i]['actuacion_procesal']);
        columna.push(datos[i]['estado'] == null ? 'N/A' : datos[i]['estado']);
        columna.push(datos[i]['justificacion_fin'] == null ? 'N/A' : datos[i]['justificacion_fin']);
        columna.push(datos[i]['usuario_crea'] == null ? 'N/A' : datos[i]['usuario_crea']);
        columna.push(datos[i]['tipo_victima'] == null ? 'N/A' : datos[i]['tipo_victima']);
        columna.push(datos[i]['corr_delito'] == null ? 'N/A' : datos[i]['corr_delito']);
        columna.push(datos[i]['corr_despacho'] == null ? 'N/A' : datos[i]['corr_despacho']);
        columna.push(datos[i]['indiciado'] == null ? 'N/A' : datos[i]['indiciado']);
        columna.push(datos[i]['victimas'] == null ? 'N/A' : datos[i]['victimas']);
        columna.push(datos[i]['cc_usuario_crea'] == null ? 'N/A' : datos[i]['cc_usuario_crea']);
        filas.push(columna);
    }
    var titulo = texto + '    ' + DDMMYYYY(new Date());
    var archivo = 'INFORME_DETALLE_AGENCIAS_ESPECIALES_' +  DDMMYYYY(new Date()).replace(/\//g, "-"); 
    table = $('#tablaDatos').DataTable({
        paging: true,
        info: false,
        columnDefs: [
            { targets: 8, width: '600px' },
            { targets: 10, width: '600px' },
            { targets: 12, width: '800px' }
        ],
        data: filas,
        dom: 'Bfrtp',
        buttons: [{
            extend: 'excelHtml5', 
            title: titulo, 
            filename: archivo
        }],
        language: { url: SpanishDT }
    });
}

function FiltrarColumna(columna, valor){
    table.columns(columna).search(valor).draw();
}