@extends('layouts.app-prueba')
@section('content')
    <div class="container p-3">
        <h4 class="text-dark">
            Detalle de {{ $modulo->nombre }}

        </h4>

        <div class="row">
            <h5 class="col-sm-4">
                Ponderación total: <span
                    @if($modulo->totalModulo() === 100)
                        class="text-success"
                    @else
                        class="text-warning"
                    @endif
                    id="cargo-u-materia-{{$modulo->id}}">{{$modulo->totalModulo()}} %</span>

            </h5>

        </div>
        <hr/>

        <div class="row row-cols-1 row-cols-md-3 g-4">

            @foreach($cargos as $cargo)
                <div class="col">
                    <div class="card border-primary h-100">

                        <div class="card-body">
                            <h5 class="card-title">
                                <small>
                                    #{{$cargo->cargo->id}}
                                </small>


                                {{$cargo->cargo->nombre}}
                            </h5>

                            <p class="card-text">
                                Ponderación: {{$cargo->cargo->ponderacion($modulo->id)}}%<br/>
                                TFI:
                                @if ($cargo->cargo->relacionCargoModulo($modulo->id)->carga_tfi === 0)
                                    <i class="fa fa-times text-danger"></i>
                                @else
                                    <i class="fa fa-check text-success"></i>
                                @endif
                                <br/>
                                Profesores:<br/>


                                @foreach ($cargo->cargo->users as $usuario)
                                    <span class="ms-5">{{ $usuario->nombre.' '.$usuario->apellido }}</span><br/>
                                @endforeach
                            </p>

                        </div>
                        <div class="card-footer">
                            <a href="#">
                                Ver calificaciones
                            </a>
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/cargos/pondera.js') }}"></script>
    <script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            function formatText(icon) {
                return $('<span><i class="fas ' + $(icon.element).data('icon') + ' ' + $(icon.element).data('state') + '"></i> ' + icon.text + '</span>');
            }

            $('.selection-tfi').select2({
                width: "100%",
                templateSelection: formatText,
                templateResult: formatText
            });

        });

        $(document).on('click', '#formAgregar', function (event) {
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
                    $('#agregarCargoModulo').modal("show");
                    $('#agregarCargoModuloBody').html(result).show();
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

        $(document).on('change', '.change-state', function (event) {
            event.preventDefault();
            let cargo_modulo = $(this);
            let url = '/asignaRelacionCargoModulo';
            let data = {
                "cargo_modulo_id": cargo_modulo.attr('id'),
                "valor": cargo_modulo.val(),
            };
            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader-tfi-' + referencia);
            $.ajax({
                method: "POST",
                url: url,
                data: data,
                // return the result
                beforeSend: function () {
                    $laoder.show();
                },
                success: function (result) {
                    // $('#agregarCargoModulo').modal("show");
                    // $('#agregarCargoModuloBody').html(result).show();
                    if (result.tieneTfi === false) {
                        document.querySelectorAll(".selection-tfi").forEach(b => b.removeAttribute('disabled'));
                    } else {
                        document.querySelectorAll(".selection-tfi").forEach(b => {
                                if (b.value === '0') {
                                    b.setAttribute('disabled', 'disabled')
                                } else {
                                    b.removeAttribute('disabled')
                                }
                            }
                        )
                    }
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
