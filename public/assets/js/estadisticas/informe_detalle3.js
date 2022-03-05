var table = null;

$(document).ready(function() {
    InformeDetalle();
});

function InformeDetalle(){
    var datos = {delegada: delegada, tipo: tipo, actuacion: actuacion};
    _POST('json', '/estadisticas/informe/detalle3_datos', JSON.stringify(datos), function (result){
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
        columna.push(datos[i]['fecha_actuacion'] == null ? 'N/A' : datos[i]['fecha_actuacion']);
        columna.push(datos[i]['tipo_formulario'] == null ? 'N/A' : datos[i]['tipo_formulario']);
        columna.push(datos[i]['id_tipo_mp'] == null ? 'N/A' : datos[i]['id_tipo_mp']);
        columna.push(datos[i]['sinproc'] == null ? 'N/A' : datos[i]['sinproc']);
        columna.push(datos[i]['act_sinproc'] == null ? 'N/A' : datos[i]['act_sinproc']);
        if (rol > 5) {
            if (delegada == 3) {
                var sp = datos[i]['datos_denunciados'].split(';');
                columna.push(sp[0]);
                columna.push(sp[1]);
            } else {
                columna.push(datos[i]['datos_denunciados'] == '<ul>' ? 'N/A' : datos[i]['datos_denunciados']);
            }
        }
        columna.push(datos[i]['tipo_actuacion'] == null ? 'N/A' : datos[i]['tipo_actuacion']);
        columna.push(datos[i]['clase_diligencia'] == null ? 'N/A' : datos[i]['clase_diligencia']);
        columna.push(datos[i]['despacho_judicial'] == null ? 'N/A' : datos[i]['despacho_judicial']);
        columna.push(datos[i]['estado_audiencia'] == null ? 'N/A' : datos[i]['estado_audiencia']);
        columna.push(datos[i]['numero'] == null ? 'N/A' : datos[i]['numero']);
        columna.push(datos[i]['numero_cordis'] == null ? 'N/A' : datos[i]['numero_cordis']);
        columna.push(datos[i]['clase'] == null ? 'N/A' : datos[i]['clase']);
        columna.push(datos[i]['autoridad'] == null ? 'N/A' : datos[i]['autoridad']);
        columna.push(datos[i]['observaciones'] == null ? 'N/A' : datos[i]['observaciones']);
        columna.push(datos[i]['link_archivo'] == null ? 'N/A' : datos[i]['link_archivo']);
        if (rol > 5) {
            columna.push(datos[i]['usuario_crea']);
            columna.push(datos[i]['cc_usuario_crea']);   
        }
        columna.push(datos[i]['fecha_crea'] == null ? 'N/A' : datos[i]['fecha_crea']);
        filas.push(columna);
    }
    var texto = $('#titulo_informe').html();
    var titulo = texto + '    ' + DDMMYYYY(new Date());
    var temp = texto.split(' - ');
    var archivo = temp[0] +  DDMMYYYY(new Date()).replace(/\//g, "-"); 
    var col = [];
    if (rol > 5) {
        col = [
            { targets: 6, width: '400px' },
            { targets: 9, width: '500px' },
            { targets: 15, width: '800px' },
            { targets: 17, width: '260px' }
        ]
    } else {
        col = [
            { targets: 5, visible: false },
            { targets: 8, width: '500px' },
            { targets: 12, width: '800px' }
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