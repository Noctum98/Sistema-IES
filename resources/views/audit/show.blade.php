@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
    <h2>Registros de '{{ ucwords($tabla) }}'</h2>
    <hr>
    @if($tabla == 'procesos')
        @include('audit.tablas.tabla_procesos')
    @endif

    @if($tabla == 'alumnos')
        @include('audit.tablas.tabla_alumnos')
    @endif
</div>
@endsection