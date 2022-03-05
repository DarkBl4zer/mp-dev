<!DOCTYPE html>
<html lang="es">
<head>
    <title>INFORME | MP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--============================= Estilos Plugins =============================-->
    <!-- Bootstrap 4.3.1 -->
    <link rel="stylesheet" href="{{asset("assets/plugins/bootstrap/css/bootstrap.min.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset("assets/plugins/font-awesome/css/all.css")}}">
    <!-- NotyJS -->
    <link rel="stylesheet" href="{{asset("assets/plugins/noty/noty.css")}}">
    <!-- Loading icon -->
    <link rel="stylesheet" href="{{asset("assets/css/loading.css")}}">
    <!-- Estilos para todas las paginas -->
    <link rel="stylesheet" href="{{asset("assets/css/para_reportes.css")}}">
    <!--============================= Estilos Plugins =============================-->

    <!--============================= Códigos Plugins =============================-->
    <!-- jQuery 3.4.1 -->
    <script src="{{asset("assets/plugins/jquery/jquery.min.js")}}"></script>
    <!-- Popper 1.14.7 -->
    <script src="{{asset("assets/plugins/popper/popper.min.js")}}"></script>
    <!-- Bootstrap 4.3.1 -->
    <script src="{{asset("assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
    <!-- Bootstrap 4.3.1 -->
    <script src="{{asset("assets/plugins/noty/noty.js")}}"></script>
    <!-- Códigos para codificar los datos en base 64 -->
    <script src="{{asset("assets/js/base64.js")}}"></script>
    <!-- Códigos para todas las paginas -->
    <script src="{{asset("assets/js/todos.js")}}"></script>
    <!--============================= Códigos Plugins =============================-->

    <!-- DataTables CSS-->
    <link rel="stylesheet" href="{{asset("assets/plugins/datatables/datatables.min.css")}}">
    <!-- DataTables Botones CSS-->
    <link rel="stylesheet" href="{{asset("assets/plugins/datatables/Buttons-1.5.6/css/buttons.bootstrap4.css")}}">

    <!-- DataTables JS-->
    <script src="{{asset("assets/plugins/datatables/datatables.min_reportes.js")}}"></script>
    <script type="text/javascript">
        var SpanishDT = "/assets/plugins/datatables/Spanish.json";
    </script>
    <!-- DataTables Botones JS-->
    <script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.js")}}"></script>
    <script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/buttons.bootstrap4.js")}}"></script>
    <script src="{{asset("assets/plugins/datatables/JSZip-2.5.0/jszip.js")}}"></script>
    <script src="{{asset("assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js")}}"></script>
    <script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/buttons.html5.js")}}"></script>
    <script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/buttons.print.js")}}"></script>
    <script src="{{asset("assets/plugins/datatables/Buttons-1.5.6/js/buttons.colVis.js")}}"></script>
</head>
<body>
    <div id="cover-spin">
        <div class="loader4"></div>
    </div>
    <div class="container-fluid" style="width: 5000px;">
        <div class="row top10">
            <div class="col-sm-12">
                <h5 id="titulo_informe"></h5>
            </div>
        </div>
        <div class="row top10" id="rowExport" style="display: none;">
            <div class="col-sm-12">
                <button type="button" class="btn btn-success btn-sm" onclick="$('.buttons-excel').click();" style="background-color: #006f19; border-color: #006f19"><i class="fas fa-file-excel"></i> Exportar</button>
            </div>
        </div>
        <div class="row top10">
            <div class="col-sm-12">
                <table id="tablaDatos" class="table table-striped table-bordered" style="width:100%; font-size: 14px; display: none;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>FECHA DE INTERVENCIÓN</th>
                            <th>TIPO INTERVENCIÓN GENERAL</th>
                            <th>NÚMERO SINPROC</th>
                            <th>INTERVENCIÓN SINPROC</th>
                            <th>¿IDENTIFICA DENUNCIADO</th>
                            @if ($rol > 5)
                            <th>DATOS DEL DENUNCIADO</th>
                            @endif
                            <th>TIPO DE INTERVENCIÓN</th>
                            <th>CLASE DE DILIGENCIA</th>
                            <th>ESTADO DE LA AUDIENCIA</th>
                            <th>CRITERIO DE INTERVENCION</th>
                            <th>DESPACHO JUDICIAL</th>
                            <th>NOTICIA CRIMINAL</th>
                            <th>DELITO</th>
                            <th>NUMERO DE CORDIS</th>
                            <th>OBSERVACIONES</th>
                            <th>ARCHIVO ADJUNTO</th>
                            @if ($rol > 5)
                            <th>USUARIO CREA</th>
                            <th>CEDULA SUARIO CREA</th>
                            @endif
                            <th>FECHA DE CREACIÓN</th>                            
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(0, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(1, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(2, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(3, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(4, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(5, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(6, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(7, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(8, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(9, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(10, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(11, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(12, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(13, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(14, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(15, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(16, this.value);" placeholder="Filtrar..."></th>
                            @if ($rol > 5)
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(17, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(18, this.value);" placeholder="Filtrar..."></th>
                            <th class="tabla_buscar"><input type="text" class="form-control" onkeyup="FiltrarColumna(19, this.value);" placeholder="Filtrar..."></th>
                            @endif
                        </tr>
                    </tfoot>
                </table>
                <div id="noDatos" class="col-md-12 text-left"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var csrf = "{{csrf_token()}}";
        var nombre_actuacion = "{{$parametros['nombre_actuacion']}}";
        var delegada = "{{$parametros['delegada']}}";
        var tipo = "{{$parametros['tipo']}}";
        var actuacion = "{{$parametros['actuacion']}}";
        var rol = {{$rol}};
    </script>
    <!-- Códigos para Detalle del reporte -->
    <script src="{{asset("assets/js/estadisticas/informe_detalle2.js")}}"></script>
</body>
</html>