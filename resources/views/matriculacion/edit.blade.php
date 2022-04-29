@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8">
    <h2 class="h1 mb-4">
        Editar matriculación de {{ $matriculacion->nombres.' '.$matriculacion->apellidos }}
    </h2>
    @if(@session('mensaje_editado'))
    <div class="alert alert-success">
        {{ @session('mensaje_editado') }}
    </div>
    @endif
    @if(@session('alumno_deleted'))
    <div class="alert alert-warning">
        {{ @session('alumno_deleted') }}
    </div>
    @endif
    <form action="{{ route('matriculacion.update',['id'=>$matriculacion->id,'carrera_id'=>$carrera->id,'year'=>$año]) }}" method="POST">

    @if(isset($matriculacion) && !Auth::user())
    @include('matriculacion.campos.campos_procesos')
    @endif

    @if(Auth::user())
    @if($matriculacion->procesoCarrera($carrera->id,$matriculacion->id)->año == 1)
    <div class="form-group">
        <label for="regularidad">Condición</label>
        <select name="regularidad" id="regularidad" class="form-select">
            <option value="regular_primero" {{ isset($matriculacion) && $matriculacion->regularidad == 'regular_primero' ? "selected='selected'":'' }}>REGULAR</option>
            <option value="condicional_primero" {{ isset($matriculacion) && $matriculacion->regularidad == 'condicional_primero' ? "selected='selected'":'' }}>CONDICIONAL</option>
            <option value="recursante_primero" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_primero' ? "selected='selected'":'' }}>RECURSANTE</option>
            <option value="recursante_diferenciado_primero" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_diferenciado_primero' ? "selected='selected'":'' }}>RECURSANTE CON TRAYECTORIA DIFERENCIADA</option>
        </select>
    </div>
    @elseif($matriculacion->procesoCarrera($carrera->id,$matriculacion->id)->año == 2)
    <div class="form-group">
        <label for="regularidad">Condición</label>
        <select name="regularidad" id="regularidad" class="form-select">
            <option value="regular_segundo" {{ isset($matriculacion) && $matriculacion->regularidad == 'regular_segundo' ? "selected='selected'":'' }}>REGULAR</option>
            <option value="condicional_segundo" {{ isset($matriculacion) && $matriculacion->regularidad == 'condicional_segundoo' ? "selected='selected'":'' }}>CONDICIONAL</option>
            <option value="recursante_segundo" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_segundo' ? "selected='selected'":'' }}>RECURSANTE</option>
            <option value="recursante_diferenciado_segundo" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_diferenciado_segundo' ? "selected='selected'":'' }}>RECURSANTE CON TRAYECTORIA DIFERENCIADA</option>
        </select>
    </div>
    @elseif($matriculacion->procesoCarrera($carrera->id,$matriculacion->id)->año == 3)
    <div class="form-group">
        <label for="regularidad">Condición</label>
        <select name="regularidad" id="regularidad" class="form-select">
            <option value="regular_tercero" {{ isset($matriculacion) && $matriculacion->regularidad == 'regular_tercero' ? "selected='selected'":'' }}>REGULAR</option>
            <option value="condicional_tercero" {{ isset($matriculacion) && $matriculacion->regularidad == 'condicional_tercero' ? "selected='selected'":'' }}>CONDICIONAL</option>
            <option value="recursante_tercero" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_tercero' ? "selected='selected'":'' }}>RECURSANTE</option>
            <option value="recursante_diferenciado_tercero" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_diferenciado_tercero' ? "selected='selected'":'' }}>RECURSANTE CON TRAYECTORIA DIFERENCIADA</option>
        </select>
    </div>
    @endif
    @endif

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