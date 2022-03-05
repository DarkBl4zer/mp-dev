@extends("plantilla.base")
@section('titulo')
POLICIVOS PARTE
@endsection
@section('plugins')

@endsection
@section('regresar')
<a href="{{route('inicio')}}" style="position:fixed; left:-10px; top: 72px; display:block; z-index:99999;">
    <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="" data-original-title="Volver a Principal">
        <i class="fas fa-ellipsis-v"></i> <span style="font-size: 10px; vertical-align: middle;">INTERVENCIÓN</span>
    </button>
</a>
@endsection
@section('contenido')
<div class="card" style="margin-top: 30px;">
    <div class="card-header">
        <strong>POLICIVOS PARTE</strong>
    </div>
    <div class="card-body">
        <div class="row" style="padding-top: 20px;">
            <div class="col-sm-2">
                <a href="{{route('movilidad_parte')}}" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> MOV</a>
            </div>
            <div class="col-sm-10">
                <a href="{{route('movilidad_parte')}}" class="btn btn-primary" style="width: 100%;text-align: left;">MOVILIDAD</a>
            </div>
        </div>
        <div class="row" style="padding-top: 20px;">
            <div class="col-sm-2">
                <a href="{{route('juzgados_parte')}}" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> JUZ</a>
            </div>
            <div class="col-sm-10">
                <a href="{{route('juzgados_parte')}}" class="btn btn-primary" style="width: 100%;text-align: left;">JUZGADOS</a>
            </div>
        </div>
        <div class="row" style="padding-top: 20px;">
            <div class="col-sm-2">
                <a href="{{route('segunda_parte')}}" class="btn btn-primary" style="width: 100%;"><i class="far fa-chart-bar"></i> SEG</a>
            </div>
            <div class="col-sm-10">
                <a href="{{route('segunda_parte')}}" class="btn btn-primary" style="width: 100%;text-align: left;">SEGUNDA</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('codigos')
@endsection