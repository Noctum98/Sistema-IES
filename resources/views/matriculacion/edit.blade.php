@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8">
    <a href="{{url()->previous()}}">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>
    <h2 class="h1 mb-4 text-info">
        Inscripción de {{ $matriculacion->nombres.' '.$matriculacion->apellidos }}
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

        @if(isset($matriculacion) && Session::has('alumno'))
            @include('matriculacion.campos.campos_procesos')
        @endif
        
        <div class="form-group">
            <div class="form-group col-md-6">
                <label for="active">Activo: </label>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="active" id="active-si" value="1" {{ isset($matriculacion) && $matriculacion->active == 1 || old('active') ? 'checked' : '' }}>
                    <label class="form-check-label" for="active-si">
                        Si
                    </label>
                </div>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="active" id="active-no" value="0" {{ isset($matriculacion) && $matriculacion->active == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active-no">
                        No
                    </label>
                </div>
            </div>
        </div>

        {{ method_field('PUT') }}



        @include('matriculacion.campos')
        <hr>
        @include('matriculacion.campos.campos_generales')
        @include('matriculacion.campos.campos_domicilio')
        @include('matriculacion.campos.campos_personales')
        @include('matriculacion.campos.campos_discapacidad')

        @if(!Session::has('coordinador') && !Session::has('regente') && !Session::has('admin') && !Session::has('seccionAlumnos'))
        @if($año == 1)
        @include('matriculacion.campos.campos_primero')
        @elseif($año == 2)
        @include('matriculacion.campos.campos_segundo')
        @elseif($año == 3)
        @include('matriculacion.campos.campos_tercero')
        @endif
        @endif

        @if(Session::has('coordinador') || Session::has('regente') || Session::has('admin') || Session::has('seccionAlumnos'))
        <input type="submit" value="Editar Matriculación" class="btn btn-primary mt-3 col-md-12">

        @else
        @if(!$matriculacion->getEncuestaSocioeconomica() || ($matriculacion->getEncuestaSocioeconomica() && !$matriculacion->getEncuestaSocioeconomica()->completa))
        <input type="submit" value="Siguiente" class="btn btn-primary mt-3 col-md-12">
        @else
        <input type="submit" value="Editar Matriculación" class="btn btn-primary mt-3 col-md-12">
        @endif
        @endif

        
    </form>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/matriculacion/create.js') }}"></script>
<script src="{{ asset('js/matriculacion/procesos.js') }}"></script>
<script src="{{ asset('js/matriculacion/botones.js') }}"></script>

@endsection