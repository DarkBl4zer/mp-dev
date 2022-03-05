var delegada = 0;
function InformeGeneral(tipo){
    delegada = tipo;
    var datos = {tipo: tipo};
    _POST('html', '/estadisticas/informe/general', JSON.stringify(datos), function (result){
        $('#espacioModal').html(result);
    });
}

function GenerarDetalle(tipo, actuacion){
    $('#delegada').val(delegada);
    $('#tipo').val(tipo);
    $('#actuacion').val(actuacion);
    $('#formDetalle').submit();
}