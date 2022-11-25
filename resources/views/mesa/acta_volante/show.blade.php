@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Mesa {{ $mesa->materia->nombre }}
    </h2>
    <hr>

    @include('layouts.alerts')

    @if(!$mesa->cierre_profesor)
        <button class="llamado btn btn-sm btn-warning mb-3" id="1" data-bs-toggle="modal" data-bs-target="#cerrarActa{{$mesa->id}}">Cerrar 1er llamado</button>
    @endif

    @if(!$mesa->cierre_profesor_segundo)
    <button class="llamado btn btn-sm btn-warning mb-3" id="2" data-bs-toggle="modal" data-bs-target="#cerrarActa{{$mesa->id}}">Cerrar 2do llamado</button>
    @endif

    @include('mesa.modals.alerta_acta_volante')


    <h2 class="text-info">Primer llamado</h2>

    @if( count($mesa->mesa_inscriptos_primero) > 0)
        @include('mesa.acta_volante.tabla_inscriptos',['inscripciones'=>$mesa->mesa_inscriptos_primero,'cierre'=>$mesa->cierre_profesor])
    @else
        <p>No existen inscripciones para este llamado.</p>
    @endif

    @if(count($mesa->bajas_primero) > 0)
        <h2 class="text-info">Primer llamado bajas</h2>
        @include('mesa.acta_volante.tabla_bajas',['inscripciones'=>$mesa->bajas_primero])
    @endif

    @if( count($mesa->mesa_inscriptos_segundo) > 0)
        <h2 class="text-info">Segundo llamado</h2>
        @include('mesa.acta_volante.tabla_inscriptos',['inscripciones'=>$mesa->mesa_inscriptos_segundo,'cierre'=>$mesa->cierre_profesor_segundo])
    @endif

    @if(count($mesa->bajas_segundo) > 0)
        <h2 class="text-info">Segundo llamado bajas</h2>
        @include('mesa.acta_volante.tabla_bajas',['inscripciones'=>$mesa->bajas_segundo])
    @endif

    @endsection

    @section('scripts')
    <script src="/js/mesas/cierre.js"></script>
    <script src="/js/mesas/nota.js"></script>
    @endsection