@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h4 class="text-dark text-center">
            Detalle trianual del alumno: <i>{{$trianual->getAlumno()->getApellidosNombresAttribute()}}</i>
        </h4>
        <hr>
        <div class="row">
            <div class="col-sm-6 border-info border-bottom border-end mb-1 px-3">Carrera:
                <b>{{$trianual->getCarrera()->nombre}}</b></div>
            <div class="col-sm-3 border-info border-bottom border-end mb-1">Cohorte:
                <b>{{$trianual->getAlumno()->cohorte}}</b></div>
            <div class="col-sm-3 border-info border-bottom border-end mb-1"> Matrícula: <b>{{$trianual->matricula}}</b>
            </div>
            <div class="col-sm-4 border-info border-bottom border-end mb-1 px-3"> Resolución:
                <b>{{$trianual->resolucion??'No indicada'}}</b></div>
            <div class="col-sm-4 border-info border-bottom border-end mb-1">Libro:
                <b>{{$trianual->libro??'No indicado'}}</b></div>
            <div class="col-sm-4 border-info border-bottom border-end mb-1"> Folio:
                <b>{{$trianual->folio??'No indicado'}}</b></div>
            <div class="col-sm-6 border-info border-bottom border-end mb-1 px-3">Promedio:
                <b>{{$trianual->promedio??'No indicado'}}</b></div>
            <div class="col-sm-6 border-info border-bottom border-end mb-1">Fecha egreso:
                <b>{{$trianual->fecha_egreso??'No indicada'}}</b></div>
            <div class="col-sm-4 border-info border-bottom border-end mb-1 px-3">Preceptor firma:
                <b>{{optional($trianual->getOperador($trianual->preceptor))->getApellidoNombre()??'No indicado'}}</b>
            </div>
            <div class="col-sm-4 border-info border-bottom border-end mb-1"> Coordinador firma:
                <b>{{optional($trianual->getOperador($trianual->coordinator))->getApellidoNombre()??'No indicado'}}</b>
            </div>
            <div class="col-sm-4 border-info border-bottom border-end mb-1">Grabó:
                <b>{{$trianual->getOperador($trianual->operador_id)->getApellidoNombre()}}</b></div>
        </div>

        <div id="detail-trianual" class="row mt-3">
            @include('trianual.detalle.components.detail_trianual')
            @include('trianual.detalle.components.form_agregar_detalle')
        </div>

    </div>
@endsection
@section('scripts')
    <script>


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
                    $('#editModal').modal("show");
                    $('#editBody').html(result).show();
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
