@extends('layouts.app-prueba')
@section('content')

    <h4 class="mt-4">Ciclos lectivos</h4>
    <hr>

    <div class="card mb-4">
        <div class="card-body">
            Listado de los ciclos lectivos con sus fechas de cierre.
            @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('ciclo_lectivo.create') }}" class="btn btn-sm btn-success ml-5">
                    Crear Ciclo Lectivo
                </a>
            @endif
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Ciclos lectivos desde 1986
        </div>
        <div class="card-body row ">
            <table
                class="table table-hover table-bordered table-striped table-responsive-xxl">
                <thead>
                <tr class="w-100">
                    <th scope="col">Año</th>
                    <th scope="col">Cierre 1<sup>er</sup> Semestre</th>
                    <th scope="col">Cierre 2<sup>do</sup> Semestre</th>
                    <th scope="col">Cierre Anual</th>
                    <th class="text-center" scope="col"><i class="fa fa-cogs"></i></th>
                </tr>
                </thead>


                <tbody>
                @foreach($ciclos as $ciclo)
                    <tr class="w-100">
                        <td class="text-center" scope="row">{{$ciclo->year}}</td>
                        <td class="text-center"> {{$ciclo->fst_sem}}</td>
                        <td class="text-center">{{$ciclo->snd_sem}}</td>
                        <td class="text-center">{{$ciclo->anual}}</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-warning" data-bs-toggle="modal" id="editButton"
                               data-bs-target="#modalModal"
                               data-loader="{{$ciclo->id}}"
                               data-attr="{{ route('ciclo_lectivo.edit', $ciclo) }}">
                                <i class="fas fa-edit text-gray-300"></i>
                                <i class="fa fa-spinner fa-spin" style="display: none"
                                   id="loader{{$ciclo->id}}"></i>
                            </a>
                            <a class="btn btn-sm btn-info" data-bs-toggle="modal" id="agregarButton"
                               data-bs-target="#modalModal"
                               data-loader="{{$ciclo->id}}"
                               data-attr="{{ route('ciclo_lectivo_especial.create', $ciclo) }}">
                                <i class="fas fa-edit text-gray-300"></i>
                                <i class="fa fa-spinner fa-spin" style="display: none"
                                   id="loader{{$ciclo->id}}"></i>
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('parameters.ciclo_lectivo.modal.form_modal_ciclo_lectivo')
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(".button").click(function () {
                $(".overlay").show({width: "0px"});
            });
            $(".oculto").click(function () {
                $(".overlay").hide({width: "100%"});
            });

        })
        $(document).on('click', '#editButton', function (event) {
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
                    $('#modalModal').modal("show");
                    $('#modalBody').html(result).show();
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 8000
            })
        });

        $(document).on('click', '#agregarButton', function (event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');

            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader' + referencia);
            $("#modalModal").on("hidden.bs.modal", function(){
                $("#modalBody").html("");
            });

            $.ajax({

                url: href,
                beforeSend: function () {
                    $laoder.show();
                    $("#modalBody").html("");
                },
                // return the result
                success: function (result) {


                    $('#modalModal').modal("show");


                    $('#modalBody').html(result).show();
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 8000
            })
        });
    </script>
@endsection
