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
</style>
<div class="container">
    <div class="dropdown mb-2">
        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdown1"
            data-bs-toggle="dropdown">
            Cohorte <span id="ciclo_lectivo">{{$cohorte}}</span>
        </button>
        <ul class="dropdown-menu">
            @foreach ($cohortes as $i)
            <li>
                <a class="dropdown-item @if($i == $cohorte) active @endif "
                    href="{{ route('proceso.alumnoCarrera',
                                    ['idAlumno'=> $alumno->id,'idCarrera' => $carrera->id, 'cohorte'=> $i]) }}">
                    {{$i}}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="card">
        <div class="row">
            <div class="card-body col-sm-6 mx-auto">
                <h5 class="card-title ms-2">
                    <i>
                        {{ ucwords($alumno->nombres) }}<br />
                        {{ ucwords($alumno->apellidos) }}
                    </i>
                </h5>
            </div>
            <div class="card-body col-sm-6 mx-auto">
                <p class="card-text">
                    <small
                        class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger">
                        Funcionalidad Beta <span class="visually-hidden"></span>
                    </small>
                    Desempeño Académico <br />
                    <b>{{mb_strtoupper($carrera->nombre)}}</b>
                    <br /><small>{{$carrera->años}} años</small>
                </p>

            </div>
        </div>
    </div>
    {{-- Primer año      --}}
    <div class="card border-info p-0">
        <input type="hidden" name="cohorte" id="cohorte" value="{{ $cohorte }}">
        <div class="card-header bg-info text-dark col-sm-12 mx-auto mx-0 px-0 pt-0">
            <p class="card-text text-right m-1 p-1 me-5">1° Año
                <a class="btn btn-sm btn-info" title="Ver notas proceso"
                    href="{{ route('proceso.alumno',['id'=>$alumno->id,'carrera'=>$carrera->id, 'year'=> 1]) }}">
                    <i class="fa fa-eye"></i>
                </a>
            </p>
        </div>
        <div class="card-footer border-bottom col-sm-12 mx-auto">
            <div class="row">
                <div class="col-sm-4 px-3 border-right">
                    Materia/Módulo
                </div>
                <div class="col-sm-3  border-right">
                    Régimen
                </div>
                <div class="col-sm-3  border-right">
                    Regularidad
                </div>

                <div class="col-sm-2 ">
                    Nota final
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-body col-sm-12 mx-auto">
                @foreach($carrera->materias()->get() as $materia)
                @if($materia->año == 1)
                <div class="row">
                    <div class="col-sm-4 px-3 border-right">
                        <p class="card-text">
                            <b>{{$materia->nombre}}</b>
                        </p>
                    </div>
                    <div class="col-sm-3 px-3 border-right">
                        <p class="card-text">
                            <span class="d-sm-none mr-5">
                                Régimen
                            </span>
                            @if($materia->regimen)
                            <i> {{$materia->regimen}}</i>
                            @else
                            <small><i>No indicado</i></small>
                            @endif
                        </p>
                    </div>
                    <div class="col-sm-3 border-right">
                        <p class="card-text text-left pl-1">
                            <span class="d-sm-none mr-5">
                                Regularidad
                            </span>
                            {!! mb_strtoupper($materia->getEstadoAlumnoPorMateria($alumno->id,$alumnoCarrera)) !!}
                        </p>
                    </div>
                    <div class="col-sm-2">
                        <p class="card-text text-left pl-1">
                            <span class="d-sm-none mr-5">
                                Nota final
                            </span>
                            @if($materia->getActaVolante($alumno->id,$alumnoCarrera))
                            <i class="fa fa-edit text-primary" style="font-size: 0.5em"></i>
                            @include('componentes.colorNotas',[
                            'year'=> $materia->getActaVolante($alumno->id,$alumnoCarrera)->mesaAlumno()->first()->mesa()->first()->instancia()->first()->year_nota,
                            'nota' => $materia->getActaVolante($alumno->id,$alumnoCarrera)->promedio
                            ])
                            <small style="font-size: 0.8em">
                                <i class="fa fa-calendar-alt text-primary" style="font-size: 0.7em"></i>
                                {{$materia->getActaVolante($alumno->id,$alumnoCarrera)
                                                ->mesaAlumno()->first()->fechaMesa()}}
                            </small>
                            <small class="popoverElement"
                                data-bs-toggle="popover"
                                data-alumno-id="{{$alumno->id}}"
                                data-materia-id="{{$materia->id}}">
                                <i class="fa fa-eye text-info"></i>
                            </small>
                            @else
                            -
                            @endif

                        </p>
                    </div>

                </div>
                <hr class="m-1 p-0" />
                @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- Segundo año     --}}
    <div class="card border-info p-0">
        <div class="card-header bg-info text-dark col-sm-12 mx-auto mx-0 px-0 pt-0">
            <p class="card-text text-right m-1 p-1 me-5">2° Año
                <a class="btn btn-sm btn-info" title="Ver notas proceso"
                    href="{{ route('proceso.alumno',['id'=>$alumno->id,'carrera'=>$carrera->id, 'year'=> 2]) }}">
                    <i class="fa fa-eye"></i>
                </a>
            </p>
        </div>
        <div class="card-footer border-bottom col-sm-12 mx-auto">
            <div class="row">
                <div class="col-sm-4 px-3 border-right">
                    Materia/Módulo
                </div>
                <div class="col-sm-3  border-right">
                    Régimen
                </div>
                <div class="col-sm-3  border-right">
                    Regularidad
                </div>

                <div class="col-sm-2 ">
                    Nota final
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-body col-sm-12 mx-auto">
                @foreach($carrera->materias()->get() as $materia)
                @if($materia->año == 2)
                <div class="row">
                    <div class="col-sm-4 px-3 border-right">
                        <p class="card-text">
                            <b>{{$materia->nombre}}</b>
                        </p>
                    </div>
                    <div class="col-sm-3 px-3 border-right">
                        <p class="card-text">
                            <span class="d-sm-none mr-5">
                                Régimen
                            </span>
                            @if($materia->regimen)
                            <i> {{$materia->regimen}}</i>
                            @else
                            <small><i>No indicado</i></small>
                            @endif
                        </p>
                    </div>
                    <div class="col-sm-3 border-right">
                        <p class="card-text text-left pl-1">
                            <span class="d-sm-none mr-5">
                                Regularidad
                            </span>
                            {!! mb_strtoupper($materia->getEstadoAlumnoPorMateria($alumno->id,$alumnoCarrera)) !!}
                        </p>
                    </div>
                    <div class="col-sm-2">
                        <p class="card-text text-left pl-1">
                            <span class="d-sm-none mr-5">
                                Nota final
                            </span>
                            @if($materia->getActaVolante($alumno->id,$alumnoCarrera))
                            <i class="fa fa-edit text-primary" style="font-size: 0.5em"></i>

                            @include('componentes.colorNotas',[
                            'year'=> $materia->getActaVolante($alumno->id,$alumnoCarrera)->mesaAlumno()->first()->mesa()->first()->instancia()->first()->year_nota,
                            'nota' => $materia->getActaVolante($alumno->id,$alumnoCarrera)->promedio
                            ])
                            <small style="font-size: 0.8em">
                                <i class="fa fa-calendar-alt text-primary" style="font-size: 0.7em"></i>
                                {{$materia->getActaVolante($alumno->id,$alumnoCarrera)->mesaAlumno()->first()->fechaMesa()}}
                            </small>
                            <small class="popoverElement"
                                data-bs-toggle="popover"
                                data-alumno-id="{{$alumno->id}}"
                                data-materia-id="{{$materia->id}}">
                                <i class="fa fa-eye text-info"></i>
                            </small>
                            @else
                            -
                            @endif

                        </p>
                    </div>

                </div>
                <hr class="m-1 p-0" />
                @endif
                @endforeach
            </div>
        </div>
    </div>
    {{-- Tercer año --}}
    <div class="card border-info p-0">
        <div class="card-header bg-info text-dark col-sm-12 mx-auto mx-0 px-0 pt-0">
            <p class="card-text text-right m-1 p-1 me-5">3° Año
                <a class="btn btn-sm btn-info" title="Ver notas proceso"
                    href="{{ route('proceso.alumno',['id'=>$alumno->id,'carrera'=>$carrera->id, 'year'=> 3]) }}">
                    <i class="fa fa-eye"></i>
                </a>
            </p>
        </div>
        <div class="card-footer border-bottom col-sm-12 mx-auto">
            <div class="row">
                <div class="col-sm-4 px-3 border-right">
                    Materia/Módulo
                </div>
                <div class="col-sm-3  border-right">
                    Régimen
                </div>
                <div class="col-sm-3  border-right">
                    Regularidad
                </div>

                <div class="col-sm-2 ">
                    Nota final
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-body col-sm-12 mx-auto">

                @foreach($carrera->materias()->get() as $materia)
                @if($materia->año == 3)
                <div class="row">
                    <div class="col-sm-4 px-3 border-right">
                        <p class="card-text">
                            <b>{{$materia->nombre}}</b>
                        </p>
                    </div>
                    <div class="col-sm-3 px-3 border-right">
                        <p class="card-text">
                            <span class="d-sm-none mr-5">
                                Régimen:
                            </span>
                            @if($materia->regimen)
                            <i> {{$materia->regimen}}</i>
                            @else
                            <small><i>No indicado</i></small>
                            @endif
                        </p>
                    </div>
                    <div class="col-sm-3 border-right">
                        <p class="card-text text-left pl-1">
                            <span class="d-sm-none mr-5">
                                Regularidad
                            </span>
                            {!! mb_strtoupper($materia->getEstadoAlumnoPorMateria($alumno->id,$alumnoCarrera)) !!}
                        </p>
                    </div>
                    <div class="col-sm-2">
                        <p class="card-text text-left pl-1">
                            <span class="d-sm-none mr-5">
                                Nota final
                            </span>
                            @if($materia->getActaVolante($alumno->id,$alumnoCarrera) && !$materia->getActaVolante($alumno->id,$alumnoCarrera)->mesaAlumno()->first()->estado_baja)
                            <i class="fa fa-edit text-primary" style="font-size: 0.5em"></i>
                            @include('componentes.colorNotas',[
                            'year'=> $materia->getActaVolante($alumno->id,$alumnoCarrera)->mesaAlumno()->first()->mesa()->first()->instancia()->first()->year_nota,
                            'nota' => $materia->getActaVolante($alumno->id,$alumnoCarrera)->promedio
                            ])

                            <small style="font-size: 0.8em">
                                <i class="fa fa-calendar-alt text-primary" style="font-size: 0.7em"></i>
                                {{$materia->getActaVolante($alumno->id,$alumnoCarrera)->mesaAlumno()->first()->fechaMesa()}}
                            </small>

                            <small class="popoverElement"
                                data-bs-toggle="popover"
                                data-alumno-id="{{$alumno->id}}"
                                data-materia-id="{{$materia->id}}">
                                <i class="fa fa-eye text-info"></i>
                            </small>
                            @else
                            -
                            @endif

                        </p>
                    </div>

                </div>
                <hr class="m-1 p-0" />
                @endif
                @endforeach
            </div>
        </div>
    </div>

    @endsection
    @section('scripts')
    <script src="{{ asset('js/actas_volantes/popoverAnteriores.js') }}"></script>
    @endsection