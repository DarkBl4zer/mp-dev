@extends("plantilla.base")
@section('contenido')
@php
    $htmlRoles = '<option value="0"></option>';
    foreach ($roles as $item) {
        $htmlRoles .= '<option value="' . $item->valor . '">' . $item->nombre . '</option>';
    }
@endphp
<br><br>
<form action="{{route('logear')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <label class="minilabel" for="RolUsuario">Rol de usuario</label>
    <select class="form-control" id="RolUsuario" name="RolUsuario">
        @php
            echo $htmlRoles;
        @endphp
    </select>
    <br><br>
    <button type="submit" class="btn btn-success">Logear</button>
</form>
@endsection