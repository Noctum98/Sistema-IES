@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8">
    <h2 class="h1 mb-4">
        Editar matriculación de  a {{ $carrera->sede->nombre }} - {{ $carrera->nombre }}:{{ ucwords($carrera->turno) }} 
    </h2>
    <form action="{{ route('matriculacion.update',$matriculacion->id) }}" method="POST">
        {{ method_field('PUT') }}
        @include('matriculacion.campos')
        <hr>
        @include('matriculacion.campos.campos_generales')
        @include('matriculacion.campos.campos_domicilio')
        @include('matriculacion.campos.campos_personales')
        @include('matriculacion.campos.campos_discapacidad')
        
        <input type="submit" value="Editar Matricula" class="btn btn-primary mt-3 col-md-12">
    </form>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/matriculacion/create.js') }}"></script>
@endsection