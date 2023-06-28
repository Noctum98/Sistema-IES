@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h2 text-info">
            Detalle trianual de: <i>{{$alumno->getApellidosNombresAttribute()}}</i>
        </h2>
        <hr>
        <div class="col-md-8">

            <br>
            <br>
            @if(count($trianual->getDetalle()->get()) > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Descripción</th>
                            <th scope="col">Nombre</th>
                            <th scope="col" class="text-center"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>

{{--                        Aqui @foreach() @endforeach--}}
                        </tbody>
                    </table>

                </div>
        </div>
        @else
            <h4 class="text-secondary">No se han cargado materias en el trianual</h4>
        @endif



    </div>
@endsection
@section('scripts')
    <script>


        $(document).on('click', '#editButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader'+referencia);

            $.ajax({
                url: href,
                beforeSend: function() {
                    $laoder.show();
                },
                // return the result
                success: function(result) {
                    $('#editModal').modal("show");
                    $('#editBody').html(result).show();
                },
                complete: function() {
                    $laoder.hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 8000
            })
        });
    </script>
@endsection
