@extends('layouts.app-prueba')
@section('content')
<div class="container">

    @if($mesa)
    <a href="{{ route('mesa.mesas',['id'=>$mesa->materia->carrera->id,'instancia_id'=>$instancia->id]) }}">
        <button class="btn btn-outline-info mb-2">
            <i class="fas fa-angle-left"></i>
            Volver
        </button>
    </a>
    <h2 class="h1 text-info">
        Inscripciones en {{$mesa->materia->nombre}}
    </h2>
    @if(Session::has('admin'))
    @if(time() < $mesa->cierre || (time() > strtotime($mesa->fecha) && time() < $mesa->cierre_segundo))
        <span class="text-success font-weight-bold">
            Abierta
        </span>
    @else
        <span class="text-secondary font-weight-bold">
            Cerrada
        </span>
    @endif
    @endif
            <hr>
            @if(@session('baja_exitosa'))
            <div class="alert alert-warning">
                {{@session('baja_exitosa')}}
            </div>
            @endif
            @if(@session('alumno_success'))
            <div class="alert alert-success">
                {{@session('alumno_success')}}
            </div>
            @endif
            @if(@session('alumno_error'))
            <div class="alert alert-danger">
                {{@session('alumno_error')}}
            </div>
            @endif

            <div class="mb-3">
                <button class="btn btn-sm btn-primary " data-bs-toggle="modal" data-bs-target="#inscribirAlumno">
                    Inscribir alumno
                </button>
                @include('mesa.modals.inscribir_alumno')
            </div>


            <h2 class="text-info">Primer llamado</h2>
            @if( count($primer_llamado) > 0)
            @if($mesa->cierre_profesor)
            <form action="{{route('mesa.abrir_acta',['mesa_id'=>$mesa->id])}}" method="POST" class="mt-2">
                {{method_field('PUT')}}
                <input type="hidden" name="llamado" value="1" id="llamado">
                <input type="submit" value="Abrir 1er llamado" class="btn btn-sm btn-warning">
            </form>
            @endif
            @include('mesa.tablas.tabla_inscripciones',['inscripciones'=>$primer_llamado,'llamado'=>1,'folios'=>$folios])
            @else
            <p>No existen inscripciones para este llamado.</p>
            @endif

            @if(count($primer_llamado_bajas) > 0)
            <h2 class="text-info">Primer llamado bajas</h2>
            @include('mesa.tablas.tabla_bajas_inscripciones',['bajas'=>$primer_llamado_bajas])
            @endif

            <h2 class="text-info">Segundo llamado</h2>
            @if( count($segundo_llamado) > 0)
            @if($mesa->cierre_profesor_segundo)
            <form action="{{route('mesa.abrir_acta',['mesa_id'=>$mesa->id])}}" method="POST" class="mt-2">
                {{method_field('PUT')}}
                <input type="hidden" name="llamado" value="2" id="llamado">
                <input type="submit" value="Abrir 2do llamado" class="btn btn-sm btn-warning">
            </form>
            @endif
            @include('mesa.tablas.tabla_inscripciones',['inscripciones'=>$segundo_llamado,'llamado'=>2,'folios'=>$folios_segundo])
            @else
            <p>No existen inscripciones para este llamado.</p>
            @endif
            @if(count($segundo_llamado_bajas) > 0)
            <h2 class="text-info">Segundo llamado bajas</h2>
            @include('mesa.tablas.tabla_bajas_inscripciones',['bajas'=>$segundo_llamado_bajas])


            @endif
            @else
            <h2 class="h1 text-info">
                La mesa no esta configurada.
            </h2>
            @endif
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/mesas/inscripcion.js') }}"></script>
<script src="{{ asset('js/mesas/confirmacion.js') }}"></script>
<script src="{{ asset('js/mesas/mesas.js') }}"></script>
@endsection