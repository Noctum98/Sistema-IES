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
        <div class="card">
            <div class="row">
                <div class="card-body col-sm-6 mx-auto">
                    <h5 class="card-title ms-2">
                        <i>
                            {{ ucwords($alumno->nombres) }}<br/>
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
                        Desempeño Académico <br/>
                        <b>{{strtoupper($carrera->nombre)}}</b>
                        <br/><small>{{$carrera->años}} años</small>
                    </p>

                </div>
            </div>
        </div>
        <div class="card border-info p-0">
            <div class="card-header bg-info text-dark col-sm-12 mx-auto mx-0 px-0 pt-0">
                <p class="card-text text-right m-1 p-1 me-5">1° Año</p>
            </div>
            <div class="card-footer border-bottom col-sm-12 mx-auto">
                <div class="row">
                    <div class="col-sm-4 px-3 border-right">
                        Materia
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
                                        @if($materia->regimen)
                                            <i> {{$materia->regimen}}</i>
                                        @else
                                            <small><i>No indicado</i></small>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-sm-3 border-right">
                                    <p class="card-text text-left pl-1">
                                        {!! ucwords($materia->getEstadoAlumnoPorMateria($alumno->id)) !!}
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="card-text text-center">
                                        @if($materia->getActaVolante($alumno->id))
                                            @colorAprobado($materia->getActaVolante($alumno->id)->promedio)
                                        @else
                                            -
                                        @endif

                                    </p>
                                </div>

                            </div>
                            <hr class="m-1 p-0"/>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card border-info p-0">
            <div class="card-header bg-info text-dark col-sm-12 mx-auto mx-0 px-0 pt-0">
                <p class="card-text text-right m-1 p-1 me-5">2° Año</p>
            </div>
            <div class="card-footer border-bottom col-sm-12 mx-auto">
                <div class="row">
                    <div class="col-sm-4 px-3 border-right">
                        Materia
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
                                        @if($materia->regimen)
                                            <i> {{$materia->regimen}}</i>
                                        @else
                                            <small><i>No indicado</i></small>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-sm-3 border-right">
                                    <p class="card-text text-center">
                                        {{ucwords(
                                            optional(
                                                optional($materia->getProcesoCarrera($alumno->id))->estado())
                                        ->first()->regularidad??'-')}}
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="card-text text-center">
                                        @if($materia->getActaVolante($alumno->id))
                                            @colorAprobado($materia->getActaVolante($alumno->id)->promedio)
                                        @else
                                            -
                                        @endif

                                    </p>
                                </div>

                            </div>
                            <hr class="m-1 p-0"/>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card border-info p-0">
            <div class="card-header bg-info text-dark col-sm-12 mx-auto mx-0 px-0 pt-0">
                <p class="card-text text-right m-1 p-1 me-5">3° Año</p>
            </div>
            <div class="card-footer border-bottom col-sm-12 mx-auto">
                <div class="row">
                    <div class="col-sm-4 px-3 border-right">
                        Materia
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
                                        @if($materia->regimen)
                                            <i> {{$materia->regimen}}</i>
                                        @else
                                            <small><i>No indicado</i></small>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-sm-3 border-right">
                                    <p class="card-text text-center">
                                        {{ucwords(
                                            optional(
                                                optional($materia->getProcesoCarrera($alumno->id))->estado())
                                        ->first()->regularidad??'-')}}
                                    </p>
                                </div>
                                <div class="col-sm-2">
                                    <p class="card-text text-center">
                                        @if($materia->getActaVolante($alumno->id))
                                            @colorAprobado($materia->getActaVolante($alumno->id)->promedio)
                                        @else
                                            -
                                        @endif

                                    </p>
                                </div>

                            </div>
                            <hr class="m-1 p-0"/>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
@endsection
