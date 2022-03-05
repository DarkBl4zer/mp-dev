var table = null;

$(document).ready(function() {
    InformeDetalle();
});

function InformeDetalle(){
    var datos = {tipo: tipo, actuacion: actuacion};
    _POST('json', '/estadisticas/informe/detalle6_datos', JSON.stringify(datos), function (result){
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
        if (delegada == '1' || delegada == '2') {
            var columna = [];
            columna.push(datos[i]['id'] == null ? 'N/A' : datos[i]['id']);
            columna.push(datos[i]['fecha_actuacion'] == null ? 'N/A' : datos[i]['fecha_actuacion']);
            columna.push(datos[i]['tipo_formulario'] == null ? 'N/A' : datos[i]['tipo_formulario']);
            columna.push(datos[i]['sinproc'] == null ? 'N/A' : datos[i]['sinproc']);
            columna.push(datos[i]['act_sinproc'] == null ? 'N/A' : datos[i]['act_sinproc']);
            columna.push(datos[i]['identifica_denunciado'] == null ? 'N/A' : datos[i]['identifica_denunciado']);
            columna.push(datos[i]['datos_denunciados'] == null ? 'N/A' : datos[i]['datos_denunciados']);
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
            columna.push(datos[i]['usuario_crea'] == null ? 'N/A' : datos[i]['usuario_crea']);
            columna.push(datos[i]['cc_usuario_crea'] == null ? 'N/A' : datos[i]['cc_usuario_crea']);
            columna.push(datos[i]['fecha_crea'] == null ? 'N/A' : datos[i]['fecha_crea']);
            filas.push(columna);   
        }
        if (delegada == '3' || delegada == '4' || delegada == '5') {
            var columna = [];
            columna.push(datos[i]['id'] == null ? 'N/A' : datos[i]['id']);
            columna.push(datos[i]['fecha_actuacion'] == null ? 'N/A' : datos[i]['fecha_actuacion']);
            columna.push(datos[i]['tipo_formulario'] == null ? 'N/A' : datos[i]['tipo_formulario']);
            columna.push(datos[i]['id_tipo_mp'] == null ? 'N/A' : datos[i]['id_tipo_mp']);
            columna.push(datos[i]['sinproc'] == null ? 'N/A' : datos[i]['sinproc']);
            columna.push(datos[i]['act_sinproc'] == null ? 'N/A' : datos[i]['act_sinproc']);
            columna.push(datos[i]['datos_denunciados'] == null ? 'N/A' : datos[i]['datos_denunciados']);
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
            columna.push(datos[i]['usuario_crea'] == null ? 'N/A' : datos[i]['usuario_crea']);
            columna.push(datos[i]['cc_usuario_crea'] == null ? 'N/A' : datos[i]['cc_usuario_crea']);
            columna.push(datos[i]['fecha_crea'] == null ? 'N/A' : datos[i]['fecha_crea']);
            filas.push(columna);
        }
    }
    var texto = $('#titulo_informe').html();
    var titulo = texto + '    ' + DDMMYYYY(new Date());
    var archivo = texto + ' ' +  DDMMYYYY(new Date()).replace(/\//g, "-"); 
    var ajColumna = null;
    if (delegada == '1' || delegada == '2') {
        ajColumna = [
            { targets: 5, width: '400px' },
            { targets: 10, width: '500px' },
            { targets: 15, width: '800px' },
            { targets: 18, width: '260px' }
        ]
    }
    if (delegada == '3' || delegada == '4' || delegada == '5') {
        ajColumna = [
            { targets: 5, width: '400px' },
            { targets: 12, width: '500px' },
            { targets: 15, width: '800px' },
            { targets: 18, width: '260px' }
        ]
    }
    table = $('#tablaDatos').DataTable({
        paging: true,
        info: false,
        columnDefs: ajColumna,
        data: filas,
        dom: 'Bfrtp',
        buttons: [{extend: 'excelHtml5', title: titulo, filename: archivo}],
        language: { url: SpanishDT }
    });
}

function FiltrarColumna(columna, valor){
    table.columns(columna).search(valor).draw();
}