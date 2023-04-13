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
                        <h2 class="text-info"><u>Datos de Inscripción</u></h2>
                    </li>
                    <li>
                        <strong>Condición: </strong>{{ explode("_",ucwords($alumno->regularidad))[0].' '.explode("_",ucwords($alumno->regularidad))[1] }}
                    </li>
                    <li><strong>Cohorte: </strong>{{ $alumno->cohorte?? 'No indicada'}} </li>
                    <li><strong>Activo: </strong>{{ $alumno->active?'Si': 'No'}} </li>
                    <li>
                        <strong>Inscripto a:</strong>
                        <br>
                        @if(count($carreras) > 0 )
                            @foreach($carreras as $carrera)
                                _ {{ $carrera->nombre.'('.ucwords($carrera->turno).'-'. $carrera->resolucion .') - '.$carrera->sede->nombre }}
                                <br>
                                Año: {{ $alumno->lastProcesoCarrera($carrera->id,$alumno->id, $ciclo_lectivo)->año }}
                                <br>

                                <div class="row">
                                    @if(Session::has('regente') || Session::has('coordinador') || Session::has('seccionAlumnos') || Session::has('admin'))
                                        <button class="btn btn-sm btn-primary col-md-3 mr-2" data-bs-toggle="modal"
                                                data-bs-target="#carrerasMatriculacionModal{{$carrera->id}}">Ver
                                            materias
                                        </button>
                                        @include('alumno.modals.carreras_matriculacion')

                                        <button class="btn btn-sm btn-primary col-md-3 mr-2" data-bs-toggle="modal"
                                                data-bs-target="#carrerasAñoModal{{$carrera->id}}">Cambiar año
                                        </button>
                                        @include('alumno.modals.carreras_year')
                                    @endif


                                    @if(Session::has('regente') || Session::has('coordinador') || Session::has('admin'))
                                        <button class="btn btn-sm btn-danger col-md-3" data-bs-toggle="modal"
                                                data-bs-target="#eliminarMatriculacionModal{{$carrera->id}}">Eliminar
                                        </button>
                                        @include('alumno.modals.correo_eliminar')
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </li>
                </ul>
                <span class="text-success" id="password_rees"></span>
                <div class="col-12">
                    <h4>Materias</h4>
                    <div class="row">
                        @foreach($materias as $nivel => $listado)
                            <div class="col-md-4">
                                <h3>Nivel {{ $nivel }}</h3>
                                <ul>
                                    @foreach($listado as $materia)
                                        <li>{{ $materia }}</li>
                                    @endforeach
                                </ul>
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
