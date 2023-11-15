@extends('layouts.app-prueba')
@section('content')
    @include('layouts.cssCard')
    <div class="container">
        <div class="card mb-5">
            <div class="row p-1">
                <div class="card-header border-radius">
                    <div class="row p-0">
                        <div class="col-sm-8">
                            <p class="ms-5">Listado de Materias</p>
                            <h4 class="text-dark">
                                {{ $carrera->nombre }}
                            </h4>
                        </div>
                    </div>

                </div>

                <div class="card-body">

                    <a href="{{ route('comisiones.ver',$carrera->id) }}" class="btn btn-warning mb-4">
                        Ver comisiones
                    </a>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">

            <h3 class="text-dark border-bottom">Primer Año</h3>

            @foreach($materias as $materia)
                @if($materia->año == 1)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <small>#{{ $materia->id }}</small>

                                    {{ $materia->nombre }}
                                </h5>
                            </div>
                            <div class="card-footer">
                                <a
                                    @if($carrera->tipo == 'modular' || $carrera->tipo == 'modular2')
                                        href="{{ route('admin.calificaciones.cargos',['materia_id'=>$materia->id]) }}"
                                    class="btn btn-sm btn-secondary">Ver cargos
                                    @endif
                                </a>


                                <sup class="badge badge-info" title="Total Comisiones">
                                    {{$materia->getTotalAttribute()}}
                                    @if($materia->getTotalAttribute() > 0)

                                        <a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                    @endif
                                </sup>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            <h3 class="text-dark border-bottom">Segundo Año</h3>

            @foreach($materias as $materia)
                @if($materia->año == 2)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <small>#{{ $materia->id }}</small>

                                    {{ $materia->nombre }}
                                </h5>
                            </div>
                            <div class="card-footer">
                                <a
                                    @if($carrera->tipo == 'modular' || $carrera->tipo == 'modular2')
                                        href="{{ route('admin.calificaciones.cargos',['materia_id'=>$materia->id]) }}"
                                    class="btn btn-sm btn-secondary">Ver cargos
                                    @endif
                                </a>

                                <sup class="badge badge-info" title="Total Comisiones">
                                    {{$materia->getTotalAttribute()}}
                                    @if($materia->getTotalAttribute() > 0)

                                        <a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                    @endif
                                </sup>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <h3 class="text-dark border-bottom">Tercer Año</h3>

            @foreach($materias as $materia)
                @if($materia->año == 3)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <small>#{{ $materia->id }}</small>

                                    {{ $materia->nombre }}
                                </h5>
                            </div>
                            <div class="card-footer">
                                <a
                                    @if($carrera->tipo == 'modular' || $carrera->tipo == 'modular2')
                                        href="{{ route('admin.calificaciones.cargos',['materia_id'=>$materia->id]) }}"
                                    class="btn btn-sm btn-secondary">Ver cargos
                                    @endif
                                </a>

                                <sup class="badge badge-info" title="Total Comisiones">
                                    {{$materia->getTotalAttribute()}}
                                    @if($materia->getTotalAttribute() > 0)

                                        <a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                    @endif
                                </sup>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>

    </div>

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


        // $(document).on('click', '#agregarButton', function (event) {
        //     event.preventDefault();
        //     let href = $(this).attr('data-attr');
        //
        //     let referencia = $(this).attr('data-loader');
        //     const $laoder = $('#loader' + referencia);
        //     $("#modalModal").on("hidden.bs.modal", function () {
        //         $("#modalBody").html("");
        //     });
        //
        //     $.ajax({
        //
        //         url: href,
        //         beforeSend: function () {
        //             $laoder.show();
        //             $("#modalBody").html("");
        //         },
        //         // return the result
        //         success: function (result) {
        //
        //
        //             $('#modalModal').modal("show");
        //
        //
        //             $('#modalBody').html(result).show();
        //         },
        //         complete: function () {
        //             $laoder.hide();
        //         },
        //         error: function (jqXHR, testStatus, error) {
        //             console.log(error);
        //
        //             $laoder.hide();
        //         },
        //         timeout: 8000
        //     })
        // });
    </script>
@endsection
