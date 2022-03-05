@extends("plantilla.base")
@section('contenido')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="alert alert-danger" role="alert" style="margin-top: 30px;">
            <h2>¡Error!</h2>
            @if ($error['archivo'] != 'x')
                Error no controlado, por favor comunicarce con <strong>TIC</strong>, los detalles del error son los siguientes: 
                <br><br>
                <ul>
                    <li type="disc"><strong>Archivo</strong> {{$error['archivo']}}</li>
                    <li type="disc"><strong>Linea</strong> {{$error['linea']}}</li>
                    <li type="disc"><strong>Mensaje</strong> {{$error['mensaje']}}</li>
                </ul>
            @else
                {{$error['mensaje']}}
            @endif
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button type="button" class="btn btn-primary btn-block btn-sm" onclick="javascript:history.back()"><i class="fas fa-undo-alt"></i>&nbsp;&nbsp; REGRESAR</button>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
@endsection