@extends('layouts.app-prueba')
@section('content')
    <div class="container alumno">
        <h3 class="text-primary">
            Historial Académico de: {{ ucwords($alumno->nombres.' '.$alumno->apellidos) }}
        </h3>
        <hr>
        <div class="col-md-12">
            @if(@session('mensaje_exitoso'))
                <div class="alert alert-success">
                    {{ @session('mensaje_exitoso') }}
                </div>
            @endif
            @if(@session('mensaje_procesos'))
                <div class="alert alert-warning">
                    {{ @session('mensaje_procesos') }}
                </div>
            @endif
            @if(@session('mensaje_error'))
                <div class="alert alert-danger">
                    {{ @session('mensaje_error') }}
                </div>
            @endif

            <div class="row col-md-12">
                <ul class="datos-academicos col-md-6">
                    <li>
                        <strong>Condición: </strong>{{ explode("_",ucwords($alumno->regularidad))[0].' '.explode("_",ucwords($alumno->regularidad))[1] }}
                        <strong>Cohorte: </strong>{{ $alumno->cohorte?? 'No indicada'}}
                        <strong>Activo: </strong>{{ $alumno->active?'Si': 'No'}}
                        <strong>Inscripto a:</strong>

                        @if(count($carreras) > 0 )
                            @foreach($carreras as $carrera)
                                _ {{ $carrera->nombre.'('.ucwords($carrera->turno).'-'. $carrera->resolucion .') - '.$carrera->sede->nombre }}
                                <br>
                                Año: {{ $alumno->lastProcesoCarrera($carrera->id,$alumno->id, $ciclo_lectivo)->año }}
                            @endforeach
                        @endif
                    </li>
                </ul>

                <div class="col-12">
                    <h4>Materias</h4>
                    <div class="row mt-1">
                        @foreach($materias as $nivel => $listado)
                            <div class="col-md-12 mt-2 pt-1 ">
                                <h5 class="text-center">{{ $nivel }}° Año</h5>
                                <div class="row mt-1 border ">
                                    <div class="col-4 border-1 ">Materia</div>

                                    <div class="col-2 border-1 border-left text-center ">Estado
                                    </div>
                                    <div class="col-1 border-1 border-left text-center ">Cierre
                                    </div>
                                    <div class="col-1 border-1 border-left text-center ">Nota
                                        Final
                                    </div>
                                    <div class="col-1 border-1 border-left text-center ">Global
                                    </div>
                                    <div class="col-1 border-1 border-left text-center ">
                                        Recuperatorio
                                    </div>
                                    <div class="col-1 border-1 border-left text-center ">Ciclo
                                        Lectivo
                                    </div>
                                    <div class="col-1 border-1 border-left text-center ">Acta
                                        Volante
                                    </div>

                                </div>
                                @foreach($listado as $materia)
                                    <div class="row">
                                        <div class="col-4 h-100 border">
                                            {{ $materia->nombre }}
                                        </div>
                                        {{--                                                @if(count($materia->procesoAlumnoMateria($alumno->id)) > 0)--}}
                                        <div
                                            @inject('estadosService', 'App\Services\EstadosService')
                                            class="col-2  border-1 border-left text-center border-top-0  ">{{ $estadosService->getEstadoById($materia->procesoAlumnoMateria($alumno->id)[0]->estado_id??null)??'-'}}</div>
                                        <div
                                            class="col-1  border-1  border-left text-center ">{{$materia->procesoAlumnoMateria($alumno->id)[0]->cierre??'-'}}</div>
                                        <div
                                            class="col-1  border-1 border-left text-center ">{{$materia->procesoAlumnoMateria($alumno->id)[0]->final_calificaciones??'-'}}</div>
                                        <div
                                            class="col-1  border-1 border-left text-center ">{{$materia->procesoAlumnoMateria($alumno->id)[0]->nota_global??'-'}}</div>
                                        <div
                                            class="col-1  border-1 border-left text-center ">{{$materia->procesoAlumnoMateria($alumno->id)[0]->nota_recuperatorio??'-'}}</div>
                                        <div
                                            class="col-1  border-1 border-left text-center ">{{$materia->procesoAlumnoMateria($alumno->id)[0]->ciclo_lectivo??'-'}}</div>
                                        <div
                                            class="col-1  border-1 border-left text-center ">{{$alumno->getActaVolanteMateria($materia->id)->promedio??'-'}}</div>
                                        {{--                                                @else--}}
                                        {{--                                                    <div class="col-12 border-1 border-left text-center">--}}
                                        {{--                                                        No se encontraron procesos--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                @endif--}}
                                    </div>

                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="d-inline col-md-12">
                <a href="{{ route('descargar_ficha',$alumno->id) }}" class="col-md-2 mt-4 btn btn-sm btn-primary"><i
                        class="fas fa-download"></i> Descargar PDF</a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/user/carreras.js') }}"></script>
@endsection
