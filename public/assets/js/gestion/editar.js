$(document).ready(function() {
    if (masItem != '') {
        $('#valor').attr('readonly', true);
    }
    $('#idLista').val(idLista);
    if (idLista==1 || idLista==4 || idLista==3 || idLista==9 || idLista==12) {
        $('#rowTipoMp').show();
    }
    if (idLista==2) {
        $('#rowTipoMp').show();
        $('#rowActuacion').show();
    }
    if (idLista==8 || idLista==9) {
        $('#rowCodigo').show();
    }
    if (idLista==14) {
        var html = $('#copiar').html();
        $('#pegar').html(html);
    }
    if (idLista==13) {
        ActualizarUsuarios();
        $('#rowRoles').show();
        $('#valor').attr('readonly', true);
        $('#nombre').attr('readonly', true);
    } else{
        CargarDatos();
    }
});

function ActualizarUsuarios(){
    _POST('json', '/gestion/lista/actualizar_usuarios', {}, function (result){
        if (result.length > 0) {
            LlenaTabla(result);
        } else {
            LimpiarTabla('tablaDatos');
            $("#noDatos").html('<p style="color: red">No se encontraron resultados.</p>');
        }
    });
}

// Metodo que permite consultar mediante una peticion ajax la informacion de los planes de gestion finalizados
function CargarDatos(){
    var datos = {id: idLista};
    _POST('json', '/gestion/lista/editar', JSON.stringify(datos), function (result){
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
        columna.push(datos[i]['valor']);
        columna.push(datos[i]['nombre']);
        if (idLista==1 || idLista==4 || idLista==3 || idLista==12) {  
            columna.push(datos[i]['id_tipo_mp']);
        }
        if (idLista==2) {  
            columna.push(datos[i]['id_tipo_mp']);
            columna.push(datos[i]['id_actuacion']);
        }
        if (idLista==8 || idLista==9) {
            columna.push(datos[i]['codigo']);
        }
        if (idLista==9) {
            columna.push(datos[i]['id_tipo_mp']);
        }
        if (idLista==13) {
            columna.push(datos[i]['email']);
            columna.push(datos[i]['nombre_rol']);
            var btns = '<button type="button" class="btn btn-primary" onclick="Editar(' + datos[i]['id'] + ');"><i class="fas fa-pencil-alt"></i></button>&nbsp;';
        } else{
            var btns = '<button type="button" class="btn btn-primary" onclick="Editar(' + datos[i]['id'] + ');"><i class="fas fa-pencil-alt"></i></button>&nbsp;';
            if (datos[i]['eliminado'] == 1) {
                btns += '<button type="button" class="btn btn-danger" id="btn_0_'+datos[i]['id']+'" onclick="ActivarDesactivar(0, ' + idLista + ', ' + datos[i]['id'] + ');" title="Desactivado"><i class="fas fa-eye-slash"></i></button>';
                btns += '<button type="button" class="btn btn-success" id="btn_1_'+datos[i]['id']+'" onclick="ActivarDesactivar(1, ' + idLista + ', ' + datos[i]['id'] + ');" title="Activado" style="display: none;"><i class="fas fa-eye"></i></button>';
            } else {
                btns += '<button type="button" class="btn btn-danger" id="btn_0_'+datos[i]['id']+'" onclick="ActivarDesactivar(0, ' + idLista + ', ' + datos[i]['id'] + ');" title="Desactivado" style="display: none;"><i class="fas fa-eye-slash"></i></button>';
                btns += '<button type="button" class="btn btn-success" id="btn_1_'+datos[i]['id']+'" onclick="ActivarDesactivar(1, ' + idLista + ', ' + datos[i]['id'] + ');" title="Activado"><i class="fas fa-eye"></i></button>';
            }
        }
        columna.push(btns);
        filas.push(columna);
    }
    var titulos = [];
    var ajCol = [];
    if (idLista==1 || idLista==4 || idLista==3 || idLista==12) {
        titulos = [
            { title: "VALOR" },
            { title: "NOMBRE" },
            { title: "TIPO MINISTERIO PÚBLICO" },
            { title: "ACCIONES" }
        ];
        ajCol = [
            { targets: 3, className: "text-center", width: '80px' }
        ];
    } else if (idLista==2) {
        titulos = [
            { title: "VALOR" },
            { title: "NOMBRE" },
            { title: "TIPO MINISTERIO PÚBLICO" },
            { title: "INTERVENCIÓN" },
            { title: "ACCIONES" }
        ];
        ajCol = [
            { targets: 4, className: "text-center", width: '80px' }
        ];
    } else if (idLista==8) {
        titulos = [
            { title: "VALOR" },
            { title: "NOMBRE" },
            { title: "CÓDIGO" },
            { title: "ACCIONES" }
        ];
        ajCol = [
            { targets: 3, className: "text-center", width: '80px' }
        ];
    } else if (idLista==9) {
        titulos = [
            { title: "VALOR" },
            { title: "NOMBRE" },
            { title: "CÓDIGO" },
            { title: "TIPO MINISTERIO PÚBLICO" },
            { title: "ACCIONES" }
        ];
        ajCol = [
            { targets: 4, className: "text-center", width: '80px' }
        ];
    } else if (idLista==13) {
        titulos = [
            { title: "VALOR" },
            { title: "NOMBRE" },
            { title: "EMAIL" },
            { title: "ROL" },
            { title: "ACCIONES" }
        ];
        ajCol = [
            { targets: 4, className: "text-center", width: '80px' }
        ];
    } else{
        titulos = [
            { title: "VALOR" },
            { title: "NOMBRE" },
            { title: "ACCIONES" }
        ];
        ajCol = [
            { targets: 2, className: "text-center", width: '80px' }
        ];
    }
    $('#tablaDatos').DataTable({
        columns: titulos,
        columnDefs: ajCol,
        data: filas,
        language: { url: SpanishDT }
    });
}

function Editar(idItem){
    $('#idLista').val(idLista);
    $('#idItem').val(idItem);
    var datos = {idLista: idLista, idItem: idItem};
    _POST('json', '/gestion/lista/item', JSON.stringify(datos), function (result){
        if (result.length > 0) {
            if (idLista==14) {
                $('#valor').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    opens: 'right',
                    drops: 'down',
                    startDate: moment(result[0].valor),
                    minDate: moment('2019-01-01'),
                    locale: SpanishDP
                });
            } else{
                $('#valor').val(result[0].valor);
            }
            $('#nombre').val(result[0].nombre);
            if (idLista==1 || idLista==4 || idLista==3 || idLista==9 || idLista==12) {
                $('#id_tipo_mp').val(result[0].id_tipo_mp);
            }
            if (idLista==2) {
                $('#id_tipo_mp').val(result[0].id_tipo_mp);
                var datos2 = {mp: result[0].id_tipo_mp, select: result[0].id_actuacion};
                _POST('html', '/gestion/lista/actuaciones_mp', JSON.stringify(datos2), function (result2){
                    $('#id_actuacion').html(result2);
                });
            }
            if (idLista==8 || idLista==9) {
                $('#codigo').val(result[0].codigo);
            }
            if (idLista==13) {
                $('#id_rol').val(result[0].id_rol);
            }
            $('#modalEditar').modal({backdrop: 'static', keyboard: false});
        } else {
            alert('Error al consultar la información.')
        }
    });
}

function ValidarFormulario(){
    var valida = true;
    //Campos requeridos no alternativos
    if (idLista==13) {
        var campos = ['id_rol'];
    } else {
        var campos = ['valor','nombre'];   
    }
    if (idLista==1 || idLista==4 || idLista==3 || idLista==9 || idLista==12) {
        campos.push('id_tipo_mp');
    }
    if (idLista==2) {
        campos.push('id_tipo_mp');
        campos.push('id_actuacion');
    }
    if (idLista==8 || idLista==9) {
        campos.push('codigo');
    }
    for (let i = 0; i < campos.length; i++) {
        //Verifica si el campo esta enblanco o el select esta en seleccione datos
        if (!CampoValido(campos[i], 'Campo requerido.')) {
            mover_a = campos[i];
            valida = false;
        }
    }
    if (valida) {
        $('#formCrearEditar').submit();
    }
}

function ActivarDesactivar(tipo, idLista, idItem){
    var datos = {tipo: tipo, idLista: idLista, idItem: idItem};
    _POST('json', '/gestion/lista/activar_desactivar', JSON.stringify(datos), function (result){
        llamadoNoty("<center><p><i class='fas fa-check-circle fa-3x'></i></p></center>" + result.msj, 'success', 'topRight', true, 3000, {
            onShow: function() {
                if (tipo == 0) {
                    $('#btn_0_' + idItem).hide();
                    $('#btn_1_' + idItem).show();
                } else {
                    $('#btn_1_' + idItem).hide();
                    $('#btn_0_' + idItem).show();
                }
            }
        });
    });
}

function AgregarItem(){
    $('#idItem').val(0);
    if (masItem != '') {
        $('#valor').val(masItem);
    } else{
        if (idLista==14) {
            $('#valor').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                opens: 'right',
                drops: 'down',
                startDate: moment(),
                minDate: moment('2019-01-01'),
                locale: SpanishDP
            });
        } else{
            $('#valor').val('');
        }
        $('#valor').val('');
    }
    $('#nombre').val('');
    $('#id_tipo_mp').val(0);
    $('#id_actuacion').val(0);
    $('#modalEditar').modal({backdrop: 'static', keyboard: false});
}

function ActuacionesMP(mp, sel){
    var datos = {mp: mp, select: sel};
    _POST('html', '/gestion/lista/actuaciones_mp', JSON.stringify(datos), function (result){
        $('#id_actuacion').html(result);
    });
}