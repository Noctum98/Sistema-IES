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
        <div class="card border-info p-0 mt-2">
            <div class="card-header bg-info text-dark col-sm-12">
                <p class="card-text text-right m-1 p-1 me-5">{{$i}}° Año</p>
            </div>
            <div class="card-footer border-bottom col-sm-12 mx-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Materia/Módulo</th>
                            <th scope="col">Régimen</th>
                            <th scope="col">Estado</th>
                            <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carrera->materias as $materia)
                        @if($materia->año == $i)
                        <tr>
                            <td>{{ ucwords($materia->nombre) }}</td>
                            <td>{{ $materia->regimen ?? 'No indicado' }}</td>
                            <td>
                                @if($alumno->hasProceso($materia->id,$ciclo_lectivo))
                                <span class="text-success">Inscripto</span>
                                @else
                                <span class="text-danger">No Inscripto</span>
                                @endif
                            </td>
                            <td>
                                @if($alumno->hasProceso($materia->id,$ciclo_lectivo))
                                <button class="btn btn-sm btn-danger btn-eliminar" data-bs-toggle="modal" data-bs-target="#eliminarProcesoModal" data-proceso_id="{{$alumno->procesoByMateria($materia->id,$ciclo_lectivo)->id}}">Eliminar <i class="fa fa-trash"></i></button>
                                @else
                                <a class="btn btn-sm btn-success" href="{{ route('proceso.inscribirAlumno',['alumno_id'=>$alumno->id,'materia_id'=>$materia->id,'ciclo_lectivo'=>$ciclo_lectivo]) }}">Inscribir <i class="fas fa-pencil-alt"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endfor
        @include('alumno.modals.eliminar_proceso')
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/alumnos/procesos.js') }}"></script>
@endsection