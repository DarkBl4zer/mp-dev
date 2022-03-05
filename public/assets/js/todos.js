function EsUnDiaValido(date){
    return false;
    /*
    var dia = new Date(date);
    if (dia.getDay() == 0 || dia.getDay() == 6) {
        return true; 
    }
    for (let i = 0; i < festivos.length; i++) {
        if (date.format('YYYY-MM-DD') == festivos[i]) {
            return true; 
        }   
    }
    */
}

function irAprincipal(){
    location.href ="https://dev.personeriabogota.gov.co/sinproc_P1/menuBootstrap.php";
}

function _POST(xType, xUrl, xData, xBack){
    $.ajax({
        url: xUrl,
        data: xData,
        type: 'POST',
        headers: {'X-CSRF-TOKEN': csrf},
        contentType: "application/json; charset=utf-8",
        dataType: xType,
        beforeSend: function () { $('#cover-spin').show(); },
        success: function () { $('#cover-spin').hide(); }
    }).done(xBack).fail(function (XMLHttpRequest, textStatus, errorThrown) {
        // En caso de error al generar la peticion ajax se imprime en consola el error
        var msj = "Text Status = " + textStatus + "\n"
            + "Error Thrown = " + errorThrown;
        console.error("ResponseText = " + XMLHttpRequest.responseText);
    });
}

// Metodo que permite limpiar los datos y eliminar la tabla
function LimpiarTabla(idTabla) {
    if ($.fn.DataTable.isDataTable('#'+idTabla)) {
        var table = $('#'+idTabla).DataTable();
        table.destroy();
        table.clear();
        $('#'+idTabla).empty();
    }
}

function FiltrarCaracteres(esto, tipo, cont = false) {
    var valor = esto.value;
    var out = '';
    var filtro = '';
    if (tipo == 'numeros') {
        filtro = '1234567890';
    }
    if (tipo == 'fechas') {
        filtro = '1234567890/';
    }
    if (tipo == 'cordis') {
        valor = valor.toUpperCase();
        filtro = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    if (tipo == 'textos') {
        valor = valor.toUpperCase();
        filtro = 'abcdefghijklmnñopqrstuvwxyzáéíóúüABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚÜ-()_,;.?¿¡!/%=$#:@1234567890" ';
    }
    if (tipo == 'nombres') {
        valor = valor.toUpperCase();
        filtro = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚÜ ';
    }
    for (var i = 0; i < valor.length; i++){
        if (valor.charAt(i) == "\n") {
            out += valor.charAt(i);
        }
        if (filtro.indexOf(valor.charAt(i)) != -1){
            out += valor.charAt(i);
        }
    }
    if (cont) {
        if (esto.id == 'descripcion') {
            var cuenta = 1900 - out.length;
        } else {
            if (esto.id == 'nombre') {
                var cuenta = 255 - out.length;
            } else {
                var cuenta = 1000 - out.length;
            }
        }
        $('#cont_' + esto.id).html('<i class="fas fa-align-left"></i> ' + cuenta);   
    }
    return out;
}

function ValidarMinimo(id, tam, nreq = false){
    $('#M'+id).html('').hide();
    var valida = true;
    var valor = $('#'+id).val();
    if (nreq) {
        
        if (valor.length > 0) {
            if (valor.length < tam) {
                $('#M'+id).html('La cantidad de caracteres debe ser mínimo ' + tam + '.');
                $('#M'+id).show();
                valida = false;
            }
        }
    } else {
        if (valor.length < tam) {
            $('#M'+id).html('La cantidad de caracteres debe ser mínimo ' + tam + '.');
            $('#M'+id).show();
            valida = false;
        }
    }
    return valida;
}

//Metodo que permite validar si la cadena de texto esta compuesta de solo espacios en blanco
function EsBlanco(string) {
    var valida = true;
    if (string.length != 0) {
        for (var i = 0; i < string.length; i++) {
            if (string.charAt(i) != ' ') {
                valida = false;
            };
        }
    }
    return valida;
}

function CampoValido(id, msj){
    var valida = true;
    if ($('#' + id).val() === null || EsBlanco($('#' + id).val())) { 
        $('#M' + id).show();
        $('#M' + id).html(msj);
        $('#' + id).val('');
        valida = false;
    } else { 
        $('#M' + id).html('');
        $('#M' + id).hide();
    }
    return valida;
}

function llamadoNoty(msg,type,layout,progressBar,timeout,back=false){
    new Noty({
        type: type, //alert (default), success, error, warning, info - ClassName generator uses this value → noty_type__${type}
        layout: layout, //top, topLeft, topCenter, topRight (default), center, centerLeft, centerRight, bottom, bottomLeft, bottomCenter, bottomRight - ClassName generator uses this value → noty_layout__${layout}
        theme: 'bootstrap-v4', //relax, mint (default), metroui - ClassName generator uses this value → noty_theme__${theme}
        text: msg, //This string can contain HTML too. But be careful and don't pass user inputs to this parameter.
        killer: true,
        progressBar: progressBar,
        timeout: timeout,
        callbacks: back
    }).show();
}

function NombreArchivo(ruta){
    return ruta.split('\\').pop();
}

function ArchivoValido(id, tipos, peso){
    $('#M'+id).html('').hide();
    var valida = true;
    var fileInput = $('#' + id);
    var maxSize = peso * 1000000;
    if(fileInput.get(0).files.length){
        $('#txt_' + id).val(fileInput.get(0).files[0].name);
        var extArchivo = fileInput.get(0).files[0].name.split('.').pop().toLowerCase();
        var fileSize = fileInput.get(0).files[0].size;
        if(fileSize > maxSize){
            $("#M" + id).html('El tamaño del archivo debe ser máximo ' + peso + 'MB.');
            $("#M" + id).show();
            valida = false;
        }
        var sp = tipos.split(';');
        var noEncontrado = true;
        var txtExt = '';
        for (let i = 0; i < sp.length; i++) {
            txtExt += ', ' + sp[i];
            if (extArchivo == sp[i]) {
                noEncontrado = false;
            }
        }
        if (noEncontrado) {
            $("#M" + id).html('El tipo de archivo seleccionado no es correcto, por favor seleccione un archivo ' + txtExt + '.');
            $("#M" + id).show();
            valida = false;
        }
    } else{
        $('#txt_' + id).val('');
        valida = false;
    }
    return valida;
}

function primerDia() {
    var today = new Date();
    var d = new Date(today), month = '' + (d.getMonth() + 1), day = '01', year = d.getFullYear();
    if (month.length < 2){ month = '0' + month; }
    return [year, month, day].join('-');
}

function DDMMYYYY(date) {
    var monthNames = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();
    return day + '/' + monthNames[monthIndex] + '/' + year;
  }