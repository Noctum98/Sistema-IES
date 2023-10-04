@extends('layouts.app-prueba')
<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">
@section('content')
    <div class="container">
        <div class="card">
            <div class="row">
                <div class="card-body col-sm-3 mx-auto">
                </div>

                <div class="card-body col-sm-9 mx-auto">
                    <p class="card-text">
                        Carga horaria de
                    </p>
                    <h5 class="card-title">
                        {{ $user->nombre.' '.$user->apellido}}
                    </h5>
                </div>
            </div>
        </div>
        <div class="card pl-5">
            <div class="row">
                @if($cargaHoraria)
                    <ul>
                        @foreach($cargaHoraria as $ch)
                            <li class="">{{$ch->materia->nombre}}: {{$ch->cantidad_horas}} Hs</li>
                        @endforeach
                        @endif
                    </ul>
                    <hr>
                    @if(@session('carrera_success'))
                        <div class="alert alert-success">
                            {{ @session('carrera_success') }}
                        </div>
                    @endif
                    @if(@session('error_sede'))
                        <div class="alert alert-warning">
                            {{ @session('error_sede') }}
                        </div>
                    @endif
                    @if(@session('error_rol'))
                        <div class="alert alert-danger">
                            {{ @session('error_rol') }}
                        </div>
                    @elseif(@session('message'))
                        <div class="alert alert-success">
                            {{ @session('message') }}
                        </div>
                    @endif
                    <div class="row col-md-12">
                        @if(count($cargaHoraria) > 0)
                            <div class="col-md-12 border mt-2 pt-2 mx-auto">
                                <div class="row ">

                                    @if(count($user->carreras) > 0)
                                        @foreach($user->carreras as $carrera)
                                            <div class="col-4 border-bottom ">
                                                <b>Carrera: {{$carrera->nombre}}</b>
                                            </div>
                                            <div class="col-4 border-bottom ">
                                                <small> <i>Res
                                                        N°:{{$carrera->resolucion.'  Turno:'.$carrera->turno}}</i></small>
                                            </div>
                                            <div class="col-4 border-bottom ">
                                                {{ $carrera->sede->nombre }}
                                            </div>
                                            <div class="col-md-1">

                                            </div>
                                            <div class="col-md-2">
                                                <u>Materias</u>
                                            </div>
                                            @foreach($user->materias as $materia)
                                                @if($materia->carrera->id == $carrera->id)
                                                    <div class="col-md-9 ms-5
                                                @if($carrera->tipo == 'modular' or $carrera->tipo == 'modular2' ) text-muted @else text-primary @endif
                                                ">
                                                        {{ $materia->nombre }}
                                                    </div>

                                                @endif
                                            @endforeach
                                            <div class="col-md-12 ms-5">
                                            </div>
                                            <div class="col-md-1">

                                            </div>
                                            <div class="col-md-2">
                                                <u>Cargos</u>
                                            </div>
                                            @foreach($user->cargos as $cargo)
                                                @if($cargo->carrera->id == $carrera->id )
                                                    <div class="col-md-9 ms-5">
                                                        {{ $cargo->nombre }}
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="col-md-9 ms-5">
                                            </div>
                                            <hr class="p-0"/>
                                        @endforeach

                                    @endif


                                </div>


                            </div>
                        @else
                            <div class="col-12">
                                <h4>No tiene carga horaria cargada</h4>
                                <a class="btn btn-sm btn-primary agregarButton" data-bs-toggle="modal"
                                   data-bs-target="#agregarModal"
                                   data-loader="{{$user->id}}"
                                   data-attr="{{ route('cargaHoraria.crear', ['persona' => $user->id])}}">
                                    <i class="fas fa-plus-square text-gray-300"></i>
                                    <i class="fa fa-spinner fa-spin" style="display: none"
                                       id="loader{{$user->id}}"></i>
                                    Agregar carga horaria
                                </a>
                            </div>
                        @endif
                    </div>
            </div>
        </div>
    </div>

    @include('cargaHoraria.components.form_modal_cargaHoraria')
@endsection
@section('scripts')
    <script src="{{ asset('js/user/carreras.js') }}"></script>
    <script src="{{ asset('js/user/cargos.js') }}"></script>
    <script src="{{asset('vendors/select2/js/select2.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $(".select2").select2({
                // dropdownParent: $('#materia_id'),
                width: "100%"
            });
        });

        $(document).on('click', '.agregarButton', function (event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader' + referencia);

            $.ajax({
                url: href,
                beforeSend: function () {
                    $laoder.show();
                },
                // return the result
                success: function (result) {
                    $('#agregaModal').modal("show");
                    $('#agregarBody').html(result).show();
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 2000
            })
        });
    </script>
@endsection
