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
    @if(time() < $mesa->cierre || (time() > strtotime($mesa->fecha) && time() < $mesa->cierre_segundo))
            <span class="text-success font-weight-bold">
                Abierta - Cierre 1er llamado: {{ date("d-m-Y", $mesa->cierre)}} | Cierre 2do llamado: {{ $mesa->fecha_segundo ? date("d-m-Y", $mesa->cierre_segundo) : '-'}}
            </span>
            @else
            <span class="text-secondary font-weight-bold">
                Cerrada - Cierre 1er llamado: {{ date("d-m-Y", $mesa->cierre)}} | Cierre 2do llamado: {{ $mesa->fecha_segundo ? date("d-m-Y", $mesa->cierre_segundo) : '-'}}
            </span>
            @endif
            <hr>

            <div class="mb-3">
                <button class="btn btn-sm btn-primary " data-bs-toggle="modal" data-bs-target="#inscribirAlumno">
                    Inscribir alumno
                </button>
                @include('mesa.modals.inscribir_alumno')

                @if(Session::has('admin'))
                    <a class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#borrar_mesa">Borrar Mesa</a>
                    @include('mesa.modals.borrar_mesa')
                @endif

            </div>


            <h2 class="text-info">
                {{$mesa->instancia->segundo_llamado ? 'Primer llamado' : 'LLamado'}}
            </h2>

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

            @if($mesa->instancia->segundo_llamado)
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