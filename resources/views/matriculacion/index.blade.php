@extends('layouts.app-prueba')
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Inscripciones de cursado
    </h2>
    <b><i>Selecciona el año que deseas cursar y completa el formulario.</i></b></br>
    <hr>
    <h4>Elige la carrera:</h4>
    <div class="table-responsive">
        @if(count($inscripciones) > 0)
        <table class="table mt-2">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Carrera</th>
                    <th scope="col">Res</th>
                    <th scope="col">UA</th>
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscripciones as $inscripcion)
                <tr style="cursor:pointer;">
                    <td>{{ $inscripcion->carrera->id }}</td>



                    <td>{{ $inscripcion->carrera->nombre.' - '.strtoupper($inscripcion->carrera->turno) }}</td>
                    <td>{{ $inscripcion->carrera->resolucion }}</td>

                    <td>{{ $inscripcion->carrera->sede->nombre}}</td>

                    <td>
                        @if(!$inscripcion->aprobado)
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#carreraAño{{$inscripcion->carrera->id}}" {{ !$inscripcion->carrera->matriculacion_habilitada ? 'disabled' :'' }}>
                            <i class="fas fa-paste"></i>
                            Inscribirse
                        </button>
                        @else
                        <span class="text-success"><strong>APROBADA</strong></span>
                        @endif
                        @include('matriculacion.modals.años')
                        @if(!$alumno->getEncuestaSocioeconomica() || ($alumno->getEncuestaSocioeconomica() && !$alumno->getEncuestaSocioeconomica()->completa))

                        <a href="{{ route('encuesta_socioeconomica.showForm',['alumno_id'=>$alumno->id,'carrera_id'=>$inscripcion->carrera->id]) }}" class="btn btn-sm btn-danger">
                            Completar Encuesta
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No hay carreras habilitadas</p>
        @endif
    </div>

    @if(!$alumno->getEncuestaSocioeconomica() || ($alumno->getEncuestaSocioeconomica() && !$alumno->getEncuestaSocioeconomica()->completa))
    <div class="alert alert-danger">
        No has completado tu <strong>ENCUESTA SOCIOECONOMICA Y MOTIVACIONAL</strong>, solo debe realizarse una sola vez.
    </div>
    @endif

    @if($alumno->getEncuestaSocioeconomica() && $alumno->getEncuestaSocioeconomica()->completa)
    <div class="alert alert-success">
        <strong>ENCUESTA SOCIOECONOMICA Y MOTIVACIONAL COMPLETA.</strong> 
    </div>
    @endif
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/matriculacion/index.js') }}"></script>
@endsection