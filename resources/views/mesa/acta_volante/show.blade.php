@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Mesa {{ $mesa->materia->nombre }}
    </h2>
    <hr>
    @if(@session('alumno_success'))
    <div class="alert alert-success">
        {{@session('alumno_success')}}
    </div>
    @endif
    <h2 class="text-info">Primer llamado</h2>

    @if( count($mesa->mesa_inscriptos_primero) > 0)
        @include('mesa.acta_volante.tabla_inscriptos',['inscripciones'=>$mesa->mesa_inscriptos_primero])
    @else
        <p>No existen inscripciones para este llamado.</p>
    @endif

    @if(count($mesa->bajas_primero) > 0)
        <h2 class="text-info">Primer llamado bajas</h2>
        @include('mesa.acta_volante.tabla_bajas',['inscripciones'=>$mesa->bajas_primero])
    @endif

    @if( count($mesa->mesa_inscriptos_segundo) > 0)
        <h2 class="text-info">Segundo llamado</h2>
        @include('mesa.acta_volante.tabla_inscriptos',['inscripciones'=>$mesa->mesa_inscriptos_segundo])
    @endif

    @if(count($mesa->bajas_segundo) > 0)
        <h2 class="text-info">Segundo llamado bajas</h2>
        @include('mesa.acta_volante.tabla_bajas',['inscripciones'=>$mesa->bajas_segundo])
    @endif

    @endsection