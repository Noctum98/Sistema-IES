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
                <span class="text-success" id="password_rees"></span>
                <div class="col-12">
                    <h4>Materias</h4>
                    <div class="row mt-1">
                        @foreach($materias as $nivel => $listado)
                            <div class="col-md-12 mt-2 pt-1 ">
                                <h5 class="text-center">{{ $nivel }}° Año</h5>
                                <div class="row mt-1 border-1">
                                    <div class="col-3 h-100 border ">Materia</div>
                                    <div class="col-9 ">
                                        <div class="row">
                                            <div class="col-2 border-top-0 text-center">Estado</div>
                                            <div class="col-2 border-1 border-left text-center border-bottom-0">Cierre</div>
                                            <div class="col-2 border-1 border-left text-center border-bottom-0">Nota Final</div>
                                            <div class="col-2 border-1 border-left text-center border-bottom-0">Global</div>
                                            <div class="col-2 border-1 border-left text-center border-bottom-0">Recuperatorio</div>
                                            <div class="col-2">Ciclo Lectivo</div>
                                        </div>
                                    </div>
                                </div>
                                @foreach($listado as $materia)
                                    <div class="row  ">
                                        <div class="col-3 h-100 border">
                                            {{ $materia->nombre }}
                                        </div>
                                        <div class="col-9 border">
                                            <div class="row h-100">
{{--                                                @if(count($materia->procesoAlumnoMateria($alumno->id)) > 0)--}}
                                                    <div
                                                        class="col-2 border-top-0 ">{{$materia->procesoAlumnoMateria($alumno->id)[0]->estado_id??'-'}}</div>
                                                    <div
                                                        class="col-2 border-1 border-left text-center border-bottom-0">{{$materia->procesoAlumnoMateria($alumno->id)[0]->cierre??'-'}}</div>
                                                    <div
                                                        class="col-2 border-1 border-left text-center border-bottom-0">{{$materia->procesoAlumnoMateria($alumno->id)[0]->final_calificaciones??'-'}}</div>
                                                    <div
                                                        class="col-2 border-1 border-left text-center border-bottom-0">{{$materia->procesoAlumnoMateria($alumno->id)[0]->nota_global??'-'}}</div>
                                                    <div
                                                        class="col-2 border-1 border-left text-center border-bottom-0">{{$materia->procesoAlumnoMateria($alumno->id)[0]->nota_recuperatorio??'-'}}</div>
                                                    <div
                                                        class="col-2 border-1 border-left text-center border-bottom-0">{{$materia->procesoAlumnoMateria($alumno->id)[0]->ciclo_lectivo??'-'}}</div>
{{--                                                @else--}}
{{--                                                    <div class="col-12 border-1 border-left text-center">--}}
{{--                                                        No se encontraron procesos--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="d-inline col-md-12">
                @if(Auth::user()->hasRole('regente') || Auth::user()->hasRole('coordinador') || Auth::user()->hasRole('seccionAlumnos') || Auth::user()->hasRole('admin'))

                    @if(!$alumno->user_id || !$alumno->aprobado)
                        <a href="{{ route('crear_usuario_alumno',['id'=>$alumno->id]) }}"
                           class="col-md-2 mt-4 btn btn-sm btn-success">
                            Confirmar alumno
                        </a>
                    @endif
                    @if(isset($carrera) && $carrera)
                        <a href="{{ route('matriculacion.edit',['alumno_id'=>$alumno->id,'carrera_id'=>$carrera->id]) }}"
                           class="col-md-2 ml-2 mr-2 mt-4 btn btn-sm btn-warning">
                            Corregir datos
                        </a>
                    @endif
                @endif

                <a href="{{ route('descargar_ficha',$alumno->id) }}" class="col-md-2 mt-4 btn btn-sm btn-primary"><i
                        class="fas fa-download"></i> Descargar PDF</a>

                @if((Session::has('coordinador') || Session::has('admin') || Session::has('regente')) && $alumno->user)
                    <button
                        class="ml-2 mt-4 btn btn-sm btn-danger {{ !$alumno->user->activo ? 'd-none' : '' }} desactivar"
                        id="desactivar-{{$alumno->user->id}}">
                        Desactivar
                    </button>

                    <button
                        class="ml-2 mt-4 btn btn-sm btn-success {{ $alumno->user->activo == 1 ? 'd-none' : '' }} activar"
                        id="activar-{{$alumno->user->id}}">
                        Activar
                    </button>

                    <button class="ml-2 mt-4 btn btn-sm btn-info btn-password" id="{{$alumno->user->id}}">
                        Restablecer Contraseña
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/user/carreras.js') }}"></script>
    <script src="{{ asset('js/user/activar.js') }}"></script>

@endsection
