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

        @if(isset($matriculacion))
            @include('matriculacion.campos.campos_procesos')
        @endif

        @if((Session::has('coordinador') || Session::has('seccionAlumnos') || Session::has('admin')) && isset($matriculacion) )
        @if($matriculacion->lastProcesoCarrera($carrera->id)->año == 1)
        <div class="form-group">
            <label for="regularidad">Condición</label>
            <select name="regularidad" id="regularidad" class="form-select">
                <option value="regular_primero" {{ isset($matriculacion) && $matriculacion->regularidad == 'regular_primero' ? "selected='selected'":'' }}>REGULAR</option>
                <option value="condicional_primero" {{ isset($matriculacion) && $matriculacion->regularidad == 'condicional_primero' ? "selected='selected'":'' }}>CONDICIONAL</option>
                <option value="recursante_primero" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_primero' ? "selected='selected'":'' }}>RECURSANTE</option>
                <option value="recursante_diferenciado_primero" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_diferenciado_primero' ? "selected='selected'":'' }}>RECURSANTE CON TRAYECTORIA DIFERENCIADA</option>
            </select>
        </div>
        @elseif($matriculacion->lastProcesoCarrera($carrera->id)->año == 2)
        <div class="form-group">
            <label for="regularidad">Condición</label>
            <select name="regularidad" id="regularidad" class="form-select">
                <option value="regular_segundo" {{ isset($matriculacion) && $matriculacion->regularidad == 'regular_segundo' ? "selected='selected'":'' }}>REGULAR</option>
                <option value="condicional_segundo" {{ isset($matriculacion) && $matriculacion->regularidad == 'condicional_segundoo' ? "selected='selected'":'' }}>CONDICIONAL</option>
                <option value="recursante_segundo" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_segundo' ? "selected='selected'":'' }}>RECURSANTE</option>
                <option value="recursante_diferenciado_segundo" {{ isset($matriculacion) && $matriculacion->regularidad == 'recursante_diferenciado_segundo' ? "selected='selected'":'' }}>RECURSANTE CON TRAYECTORIA DIFERENCIADA</option>
            </select>
        </div>
        @elseif($matriculacion->lastProcesoCarrera($carrera->id)->año == 3)
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
        <div class="form-group">
            <label for="cohorte">Cohorte:</label>
            <input type="text" id="cohorte" name="cohorte" class="form-control @error('cohorte') is-invalid @enderror" value="{{ isset($matriculacion) ? $matriculacion->cohorte : '' }}" />

            @error('cohorte')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="fecha_primera_acreditacion">Fecha Primera Acreditación:</label>
            <input type="date" id="fecha_primera_acreditacion" name="fecha_primera_acreditacion" class="form-control @error('fecha_primera_acreditacion') is-invalid @enderror" value="{{ $matriculacion->fecha_primera_acreditacion ?? '' }}" />

            @error('fecha_primera_acreditacion')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="fecha_ultima_acreditacion">Fecha Última Acreditación:</label>
            <input type="date" id="fecha_ultima_acreditacion" name="fecha_ultima_acreditacion" class="form-control @error('fecha_ultima_acreditacion') is-invalid @enderror" value="{{ $matriculacion->fecha_ultima_acreditacion ?? '' }}" />

            @error('fecha_ultima_acreditacion')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
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
        <div class="form-group">
            <div class="form-group col-md-6">
                <label for="legajo_completo">Legajo Completo: </label>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="legajo_completo" id="legajo_completo-si" value="1" {{ isset($matriculacion) && $matriculacion->legajo_completo == 1 || old('legajo_completo') ? 'checked' : '' }}>
                    <label class="form-check-label" for="legajo_completo-si">
                        Si
                    </label>
                </div>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="legajo_completo" id="legajo_completo-no" value="0" {{ isset($matriculacion) && $matriculacion->legajo_completo == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="legajo_completo-no">
                        No
                    </label>
                </div>
            </div>
        </div>
        @endif

        {{ method_field('PUT') }}



        @include('matriculacion.campos')
        <hr>
        @include('matriculacion.campos.campos_generales')
        @include('matriculacion.campos.campos_domicilio')
        @include('matriculacion.campos.campos_personales')
        @include('matriculacion.campos.campos_discapacidad')
        @if($año == 1)
        @include('matriculacion.campos.campos_primero')
        @elseif($año == 2)
        @include('matriculacion.campos.campos_segundo')
        @elseif($año == 3)
        @include('matriculacion.campos.campos_tercero')
        @endif

        @if(!$matriculacion->encuesta_socioeconomica)
        <input type="submit" value="Siguiente" class="btn btn-primary mt-3 col-md-12">
        @else
        <input type="submit" value="Editar Matriculación" class="btn btn-primary mt-3 col-md-12">
        @endif
    </form>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/matriculacion/create.js') }}"></script>
<script src="{{ asset('js/matriculacion/procesos.js') }}"></script>
<script src="{{ asset('js/matriculacion/botones.js') }}"></script>

@endsection