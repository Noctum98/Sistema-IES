@extends('layouts.app-prueba')
@section('content')
<style>
    .card {
        /*margin-top: 2em;*/
        padding: 0.5em;
        border-radius: 2em;
        /*text-align: center;*/
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }

    .card .card-header {

        padding: 0.5em;
        border-top-left-radius: 2em;
        border-top-right-radius: 2em;
        /*text-align: center;*/
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    }
</style>
<div class="container p-3">
    <div class="row">
    <a href="{{route('alumno.detalle',['id'=>$alumno->id,'ciclo_lectivo'=>$ciclo_lectivo])}}" class="btn btn-sm btn-info col-md-1" >
        Volver
    </a>
    <div class="dropdown col-md-1">
        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdown1" data-bs-toggle="dropdown">
            Ciclo lectivo {{$ciclo_lectivo}}
        </button>
        <ul class="dropdown-menu">
            @for ($i = $changeCicloLectivo[1]; $i >= $changeCicloLectivo[0]; $i--)
            <li>
                <a class="dropdown-item @if($i == $ciclo_lectivo) active @endif " href="{{route('proceso.admin',['alumno_id' => $alumno->id,'carrera_id' =>$carrera->id,'ciclo_lectivo'=>$i])}}">{{$i}}</a>

            </li>
            @endfor
        </ul>
    </div>
    </div>
    
    <h2 class="h1 text-info">Materias de {{ $alumno->nombres.' '.$alumno->apellidos }} {{ $ciclo_lectivo }}</h2>
    <hr>
    @for($i = 1; $i <= $carrera->años; $i++)
        @include('alumno.includes.tabla_materias',['año'=>$i,'materias'=>$carrera->materias,'alumno'=>$alumno,'ciclo_lectivo'=>$ciclo_lectivo])
    @endfor
    @include('alumno.modals.eliminar_proceso')
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/alumnos/procesos.js') }}"></script>
@endsection