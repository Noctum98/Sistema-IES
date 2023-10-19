@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h4>
                    <i>
                        {{ ucwords($alumno->nombres.' '.$alumno->apellidos) }} <br/>
                        <small class="float-right me-5" style="font-size: 0.6em">DNI: {{$alumno->dni}}</small>
                    </i>
                </h4>
            </div>
            <div class="col-sm-6">
                <h6 class="text-primary">
                    Notas de proceso <br/>
                    {{$carrera->nombre}}  {{$year}} año
                    <br/>
                    <small>
                        <a href="{{route('proceso.alumnoCarrera', ['idAlumno'=>$alumno->id, 'idCarrera' => $carrera->id])}}"
                           class="btn btn-sm btn-light "
                        >
                            Volver a la libreta

                        </a>
                    </small>
                </h6>
            </div>
        </div>

        <hr>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>
                        Materia
                    </th>
                    <th>
                        <small> Regularidad</small>
                    </th>
                    <th>
                        <small>
                            Trabajos <br/>
                            Prácticos
                        </small>
                    </th>
                    <th>
                        <small>
                            Parciales
                        </small>
                    </th>

                    <th class="text-right pr-3">
                        <small>Asistencia final</small>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($procesos as $proceso)
                    <tr>
                        <td>
                            {{ $proceso->materia->nombre }}
                        </td>
                        <td class="text-center">
                            {{ ucwords($proceso->estado->nombre??'No indicado') }}
                        </td>
                        <td>
                            {{ $proceso->final_parciales ?  : 'Sin asignar'}}
                        </td>
                        <td>
                            {{ $proceso->final_trabajos ?  : 'Sin asignar'}}
                        </td>
                        <td class="text-right pr-3">

                            @if($proceso->materia->carrera->tipo == 'tradicional')
                                {{ $proceso->asistencia($proceso->id) ? $proceso->asistencia($proceso->id)->porcentaje_final : 'Sin asignar'}}
                                %
                            @endif
                            @if($proceso->materia->carrera->tipo == 'tradicional2')
                                @if($proceso->asistencia($proceso->id))
                                    {{ $proceso->asistencia($proceso->id)->porcentaje_presencial ? : '-'}} %<sup>
                                        Presencial</sup> |
                                    {{ $proceso->asistencia($proceso->id)->porcentaje_virtual ? : '-'}} %<sup>
                                        Virtual</sup> <br/>
                                    {{ $proceso->asistencia($proceso->id)->porcentaje_final ? : '-'}} % <sup>Final</sup>
                                @else
                                    - %<sup> Presencial</sup> | - %<sup>Virtual</sup> <br/>
                                    - % <sup>Final</sup>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection
