@extends("plantilla.base")
@section('contenido')

<div class="accordion" id="accordionExample">
    <div class="card mb-3 border-0">
        <div class="card-header" style="background-color: #FFFFFF;">
            <button class="btn btn-block btn-sm text-justify collapsed" type="button" data-toggle="collapse" data-target="#collapseFirst" aria-expanded="false" aria-controls="collapseFirst" style="background-color: #dddddd;">
                <strong>
                    <img src="{{asset("assets/images/mp.png")}}" width="60px" height="60px"> &nbsp;&nbsp;MODULO MINISTERIO PÚBLICO
                </strong>
            </button>
        </div>
        <div id="collapseFirst" class="collapse show" aria-labelledby="headingFirst" data-parent="#accordionExample" style="">
            <div class="card-body bg-transparent">
                @include('plantilla.botones')
            </div>
        </div>
    </div>
</div>
@endsection
@section('codigos')
<script type="text/javascript">
@php
    foreach ($noti as $n) {
        echo "$('#noti_nivel1_id".$n->id_nievel1."').show();";
    }
@endphp
</script>
@endsection