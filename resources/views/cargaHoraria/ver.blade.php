@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h4 class="text-dark">Carga horaria de {{ $user->nombre.' '.$user->apellido}}</h4>
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

            <div class="col-md-11 mx-auto">
                @if($cargaHoraria)
                    <div class="col-md-11 border mt-2 pt-2 mx-auto">

                        <div class="row ">
                            @foreach($cargaHoraria as $ch)

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
                                                <div class="col-md-9 ms-5">
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

                            @endforeach
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
        @include('cargaHoraria.components.form_modal_cargaHoraria')
        @endsection
        @section('scripts')
            <script src="{{ asset('js/user/carreras.js') }}"></script>
            <script src="{{ asset('js/user/cargos.js') }}"></script>
            <script>

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
