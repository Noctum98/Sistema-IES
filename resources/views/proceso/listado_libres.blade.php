@extends('layouts.app-prueba')
@section('content')
<div class="container" id="container-scroll">
    <a href="{{url()->previous()}}">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>
    <h2 class="h1 text-info">
        Alumnos libres de {{ $materia->nombre }}
    </h2>

    <div class="card border-info p-0 mt-4">
        <div class="card-header bg-info text-dark col-sm-12">
            <p><b>Los alumnos libres no estarán visibles en las planillas de calificaciones y asistencia</b></p>
        </div>
        <div class="card-footer border-bottom col-sm-12 mx-auto">
        @if(count($procesos) > 0)

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Alumno</th>
                        <th scope="col">Ciclo Lectivo</th>
                        <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($procesos as $proceso)

                    <tr>
                        <td>
                            {{ strtoupper($proceso->alumno->apellidos)}}, {{ucwords($proceso->alumno->nombres)}}
                        </td>
                        <td>{{ $proceso->ciclo_lectivo }}</td>
                        <td>

                        @if($proceso->inscripcion->cohorte)
                        <a href="{{route('proceso.alumnoCarrera', ['idAlumno'=>$proceso->alumno_id, 'idCarrera' => $proceso->materia->carrera_id,'cohorte'=>$proceso->inscripcion->cohorte])}}"
                           class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i> Ver Libreta
                        </a>
                        @else
                        <a href="#"
                           class="btn btn-sm btn-info" disabled>
                            <i class="fa fa-eye"></i> Ver Libreta
                        </a>
                        @endif
                        
                        </td>

                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
            @else
                    <p>No hay alumnos libres en esta materia</p>
                    @endif
        </div>
    </div>
</div>
@endsection