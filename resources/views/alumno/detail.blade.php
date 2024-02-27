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

    .card li {
        list-style: none;
    }

    .card_img {
        /*width: 65%;*/
        /*border-radius: 50%;*/
        border-radius: 2em;
        margin: 0 auto 0 -50px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        background: #1a1e21;
        color: white;
        font-size: 6em;
        font-weight: bold;
    }

    .card .card-title {
        font-weight: 700;
        font-size: 1.5em;
    }

    /*.card .btn {*/
    /*    border-radius: 2em;*/
    /*    background-color: teal;*/
    /*    color: #ffffff;*/
    /*    padding: 0.5em 1.5em;*/
    /*}*/

        .card .btn:hover {
            background-color: rgba(0, 128, 128, 0.7);
            color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .disabled {
            pointer-events: all !important;
        }
    </style>
    <div class="container alumno">
        {{--        <h3 class="text-info">--}}
        {{--            Datos de {{ ucwords($alumno->nombres.' '.$alumno->apellidos) }}--}}
        {{--        </h3>--}}
        {{--        <hr>--}}
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


        <div class="card">
            <div class="row">
                <div class="card-body col-sm-3 mx-auto">
                </div>

                <div class="card-body col-sm-9 mx-auto">
                    <h5 class="card-title">
                        {{ ucwords($alumno->apellidos) }}, {{ ucwords($alumno->nombres) }}
                    </h5>
                    <p class="card-text">
                        <strong>Edad:</strong> {{ $alumno->edad ? $alumno->edad.' '.'años' : 'Sin asignar' }}<br />
                        <strong>Teléfono Celular:</strong> {{ $alumno->telefono ? : 'Sin Asignar' }}<br />
                        <strong>Teléfono Fijo:</strong> {{ $alumno->telefono_fijo ? : 'Sin Asignar' }}
                    </p>
                </div>
            </div>
        </div>


        <div class="card pl-5">
            <div class="row">
                <ul class="datos-generales col-md-6">
                    <li>
                        <h4 class="text-info"><u>Datos Generales</u></h4>
                    </li>
                    <li><strong>Email:</strong> {{ $alumno->email ? : 'Sin Asignar' }}</li>
                    <li><strong>Fecha de nacimiento: </strong> {{ $alumno->fecha ? : 'Sin Asignar' }}</li>
                    <li><strong>N° de documento: </strong> {{ $alumno->dni ? : 'Sin Asignar' }}</li>
                    <li><strong>C.U.I.L.: </strong> {{ $alumno->cuil ? : 'Sin Asignar' }}</li>
                    <li> <strong>Edad:</strong> {{ $alumno->edad ? $alumno->edad.' '.'años' : 'Sin asignar' }}<br />
                    </li>
                    <li><strong>Género: </strong> {{ ucwords($alumno->genero ? : 'Sin Asignar') }}</li>
                    <li>
                        <strong>Nacionalidad: </strong> {{ ucwords($alumno->nacionalidad) ? : 'Sin Asignar' }}
                    </li>
                </ul>
                <ul class="datos-domicilio col-md-6">
                    <li>
                        <h4 class="text-info"><u>Datos Domicilio</u></h4>
                    </li>
                    <li><strong>Localidad:</strong> {{ $alumno->localidad ? : 'Sin Asignar' }}</li>
                    <li><strong>Calle: </strong> {{ $alumno->calle ? : 'Sin Asignar' }}</li>
                    <li><strong>N° de calle: </strong> {{ $alumno->n_calle ? : 'Sin Asignar' }}</li>
                    <li><strong>Barrio: </strong> {{ $alumno->barrio ? : 'Sin Asignar' }}</li>
                    <li><strong>Manzana: </strong> {{ $alumno->manzana ? : 'Sin Asignar' }}</li>
                    <li><strong>Casa: </strong> {{ $alumno->casa ? : 'Sin Asignar' }}</li>
                    <li><strong>Código Postal: </strong> {{ $alumno->codigo_postal ? : 'Sin Asignar' }}</li>
                </ul>


                <ul class="datos-domicilio col-md-6">
                    <li>
                        <h4 class="text-info"><u>Datos Personales</u></h4>
                    </li>
                    <li><strong>Estado Civil:</strong> {{ ucwords($alumno->estado_civil? :'Sin Asignar') }}</li>
                    <li><strong>Ocupación: </strong> {{ ucwords($alumno->ocupacion? :'Sin Asignar') }}</li>
                    <li><strong>Grupo Sanguíneo: </strong> {{ mb_strtoupper($alumno->g_sanguineo? :'Sin Asignar') }}
                    </li>
                    @if($alumno->año == 1)
                    <li><strong>Escuela Secundaria: </strong> {{ $alumno->escuela_s ? : 'Sin Asignar' }}</li>
                    <li><strong>Articulo Séptimo: </strong> {{ $alumno->articulo_septimo ? 'Si' : 'No' }} </li>
                    <li><strong>Finalizo Escuela Secundaria: </strong> {{ $alumno->escolaridad ? 'Si' : 'No' }}
                    </li>
                    <li><strong>Materias que adeuda de secundario: </strong>
                        @if(!$alumno->materias_s)
                        Ninguna
                        @else
                        {{ str_replace(';',' - ',$alumno->materias_s) }}
                        @endif
                    </li>
                    <li><strong>Presento título secundario:</strong> {{$alumno->titulo_s ? 'Si' : 'No'}} </li>
                    @endif
                    <li><strong>Código Postal: </strong> {{ $alumno->codigo_postal ? : 'Sin Asignar' }}</li>
                    <li><strong>Estudiante de población
                            indígena:</strong> {{$alumno->poblacion_indigena ? 'Si' : 'No'}}
                    </li>
                    <li><strong>Privación de libertad o en regímenes
                            semi-abiertos:</strong> {{$alumno->privacidad ? 'Si' : 'No'}} </li>
                </ul>

                <ul class="datos-academicos col-md-6">
                    <li>
                        <h4 class="text-info"><u>Datos Académicos</u></h4>
                    </li>
                    <li>
                        <strong>Condición: </strong>{{ $alumno->regularidad ? explode("_",ucwords($alumno->regularidad))[0].' '.explode("_",ucwords($alumno->regularidad))[1] : 'Sin asignar' }}
                    </li>
                    <li><strong>Cohorte: </strong>{{ $alumno->cohorte?? 'No indicada'}} </li>
                    <li><strong>1<sup>er</sup> Acreditación:
                        </strong>{{ $alumno->fecha_primera_acreditacion?? 'No indicada'}} </li>
                    <li><strong>Activo: </strong>{{ $alumno->active?'Si': 'No'}} </li>
                    <li><strong>Legajo Completo: </strong> {{ $alumno->legajo_completo ? 'Si' : 'No' }} </li>

                    {{-- </ul>--}}
                    {{-- <ul class="datos-inscripcion col-md-6">--}}
                    <li>
                        <h4 class="text-info"><u>Datos de Inscripción</u></h4>
                    </li>

                    <li>
                        <strong>Inscripto a:</strong>
                        <br>
                        @if(count($carreras) > 0 )
                        @foreach($carreras as $carrera)
                        _ {{ $carrera->nombre.'('.ucwords($carrera->turno).'-'. $carrera->resolucion .') - '.$carrera->sede->nombre }}
                        <br>
                        Año: {{ $alumno->lastProcesoCarrera($carrera->id)->año }}
                        <br>
                        Ciclo: {{ $alumno->lastProcesoCarrera($carrera->id)->ciclo_lectivo }}
                        <a href="{{route('proceso.alumnoCarrera', ['idAlumno'=>$alumno->id, 'idCarrera' => $carrera->id])}}" class="btn btn-link position-relative p-1">

                                        Ver Libreta
                                        <small
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            Beta
                                            <span class="visually-hidden">Funcionalidad Beta</span>
                                        </small>
                                    </a>

                        <div class="row">
                            @if(Session::has('admin'))

                            <a href="{{ route('proceso.admin',['alumno_id' => $alumno->id,'carrera_id' =>$carrera->id,'ciclo_lectivo'=>$ciclo_lectivo]) }}" class="btn btn-sm btn-primary col-md-3 mr-2">Ver materias</a>

                            {{--
                            <button class="btn btn-sm btn-primary col-md-3 mr-2" data-bs-toggle="modal" data-bs-target="#carrerasMatriculacionModal{{$carrera->id}}">Ver
                                materias
                            </button>--}}
                            @include('alumno.modals.carreras_matriculacion')

                            <button class="btn btn-sm btn-primary col-md-3 mr-2" data-bs-toggle="modal" data-bs-target="#carrerasAñoModal{{$carrera->id}}">Cambiar año
                            </button>
                            @include('alumno.modals.carreras_year')
                            @elseif(Session::has('regente') || Session::has('coordinador') || Session::has('seccionAlumnos') || Session::has('areaSocial'))
                            @if(Auth::user()->hasCarrera($carrera->id) || Session::has('areaSocial'))
                            <button class="btn btn-sm btn-primary col-md-3 mr-2" data-bs-toggle="modal" data-bs-target="#carrerasMatriculacionModal{{$carrera->id}}">Ver
                                materias
                            </button>
                            @include('alumno.modals.carreras_matriculacion')

                                                <button class="btn btn-sm btn-primary col-md-3 mr-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#carrerasAñoModal{{$carrera->id}}">Cambiar año
                                                </button>
                                                @include('alumno.modals.carreras_year')
                                            @endif
                                        @elseif(Session::has('alumno'))
                                            <button class="btn btn-sm btn-primary col-md-3 mr-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#carrerasMatriculacionModal{{$carrera->id}}">Ver
                                                materias inscriptas {{$ciclo_lectivo}}
                                            </button>
                                            @include('alumno.modals.carreras_matriculacion')
                                        @endif
                                        @if(Session::has('admin'))
                                            <button class="btn btn-sm btn-secondary col-md-3"

                                                    @if($alumno->hasNotas())
                                                    title="El alumno tiene calificaciones."
                                                    @endif
                                                        data-bs-toggle="modal"
                                                    data-bs-target="#eliminarMatriculacionModal{{$carrera->id}}"

                                            >
                                                Eliminar Inscripción

                                            </button>

                                            @include('alumno.modals.correo_eliminar')
                                        @elseif(Session::has('regente') || Session::has('coordinador'))
                                            @if(Auth::user()->hasCarrera($carrera->id))
                                                <button class="btn btn-sm btn-secondary col-md-3
                                                    @if($alumno->hasNotas())
                                                        disabled
                                                    @endif
                                                    "
                                                        @if($alumno->hasNotas())
                                                            disabled="disabled"
                                                        title="El alumno tiene calificaciones. No se puede eliminar"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Tooltip on top"
                                                        @else
                                                            data-bs-toggle="modal"
                                                        data-bs-target="#eliminarMatriculacionModal{{$carrera->id}}"
                                                    @endif
                                                >
                                                    Eliminar Inscripción
                                                </button>
                                                @if($alumno->hasNotas())
                                                    @include('alumno.modals.correo_eliminar')
                                                @endif
                            @endif
                            @endif
                        </div>
                        @endforeach
                        @else
                        <p>Ninguna carrera.</p>
                        @endif
                    </li>
                </ul>
                <span class="text-success" id="password_rees"></span>
            </div>
        </div>

    </div>
    <hr>
    <div class="d-inline col-md-12">
        @if(Auth::user()->hasRole('regente') || Auth::user()->hasRole('coordinador') || Auth::user()->hasRole('seccionAlumnos') || Auth::user()->hasRole('admin'))

        @if(!$alumno->aprobado)
        <a href="{{ route('crear_usuario_alumno',['id'=>$alumno->id]) }}" class="col-md-2 btn btn-sm btn-success">
            Confirmar alumno
        </a>
        @endif
        @if(isset($carrera) && $carrera)
        <a href="{{ route('matriculacion.edit',['alumno_id'=>$alumno->id,'carrera_id'=>$carrera->id]) }}" class="col-md-2 ml-2 mr-2  btn btn-sm btn-warning">
            Corregir datos
        </a>
        @endif
        @endif
        @if((Session::has('admin') || Session::has('regente')) && $alumno->user)
        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarAlumnoModal{{$alumno->id}}">Eliminar Alumno
        </button>
        @include('alumno.modals.eliminar_alumno')
        @endif
        <a href="{{ route('descargar_ficha',$alumno->id) }}" class="col-md-2  btn btn-sm btn-primary"><i class="fas fa-download"></i> Descargar PDF</a>

            @if((Session::has('coordinador') || Session::has('admin') || Session::has('regente') || Session::has('seccionAlumnos')) && $alumno->user)
                @if(Session::has('coordinador') || Session::has('admin') || Session::has('regente'))
                    <button
                        class="ml-2  btn btn-sm btn-secondary {{ !$alumno->user->activo ? 'd-none' : '' }} desactivar"
                        id="desactivar-{{$alumno->user->id}}">
                        Desactivar Usuario
                    </button>
                @endif
                <button
                    class="ml-2  btn btn-sm btn-success {{ $alumno->user->activo == 1 ? 'd-none' : '' }} activar"
                    id="activar-{{$alumno->user->id}}">
                    Activar Usuario
                </button>

        <button class="ml-2  btn btn-sm btn-info btn-password" id="{{$alumno->user->id}}">
            Restablecer Contraseña
        </button>

        @endif
    </div>
    <hr>
</div>

@endsection
@section('scripts')
<script src="{{ asset('js/user/carreras.js') }}"></script>
<script src="{{ asset('js/user/activar.js') }}"></script>

@endsection
