@extends('layouts.app-prueba')
@section('content')
    @include('layouts.cssCard')
    <div class="container">
        <div class="card">
            <div class="row p-1">
                <div class="card-header border-radius">
                    <div class="row p-0">
                        <div class="col-sm-4">
                            <small>
                                <a href="{{route('carrera.admin')}}">
                                    <button class="btn btn-sm btn-outline-info mb-2">
                                        <i class="fas fa-angle-left"></i>
                                        Listado de carreras
                                    </button>
                                </a>
                            </small>
                        </div>
                        <div class="col-sm-8">
                            <p class="ms-5">Plan de estudios</p>
                            <h4 class="text-dark">
                                 {{ $carrera->nombre }}
                                <br/> <small>{{ucwords($carrera->tipo)}}</small>
                            </h4>
                        </div>
                    </div>

                </div>


                <div class="card-body">


                    @if(Session::has('admin'))
                        <a href="{{ route('materia.crear',['carrera_id'=>$carrera->id]) }}"
                           class="btn btn-success mb-4">
                            Agregar materia
                        </a>
                        <button class="btn btn-info mb-4"
                                data-bs-toggle="modal" data-bs-target="#crearComision"
                        >
                            Crear comisión
                        </button>
                    @endif

                    <a href="{{ route('comisiones.ver',$carrera->id) }}" class="btn btn-warning mb-4">
                        Ver comisiones
                    </a>


                    @if(@session('error_procesos'))
                        {{ @session('error_procesos') }}
                    @endif
                    <div class="col-md-12">

                        <h3 class="text-secondary">Primer Año</h3>
                        <table class="table table-hover mt-4">
                            <caption>1er año</caption>
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Materia</th>
                                <th scope="col" class="text-center"><i class="fa fa-cog" style="font-size:20px;"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($materias as $materia)
                                @if($materia->año == 1)
                                    <tr style="cursor:pointer;">
                                        <td>{{ $materia->nombre }}</td>
                                        <td>
                                            @if(Auth::user()->hasRole('regente') || Auth::user()->hasRole('coordinador') || Auth::user()->hasRole('seccionAlumnos') || Auth::user()->hasRole('admin'))
                                                <a href="{{ route('materia.editar',['id'=>$materia->id]) }}"
                                                   class="btn btn-sm btn-warning">Editar</a>
                                            @endif
                                            <a href="{{ route('calificacion.admin',['materia_id'=>$materia->id,'ciclo_lectivo'=>date('Y')]) }}"
                                               class="btn btn-sm btn-secondary">Ver calificaciones</a>
                                            <a href="{{ route('descargar_planilla',$materia->id) }}"
                                               class="btn btn-sm btn-success"><i
                                                    class="fas fa-download"></i> Descargar Alumnos</a>
                                            <sup class="badge badge-info" title="Total Comisiones">
                                                {{$materia->getTotalAttribute()}}
                                                @if($materia->getTotalAttribute() > 0)

                                                    <a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                @endif
                                            </sup>
                                            {{--                                    <a class="btn btn-sm btn-info" data-bs-toggle="modal" id="agregarButton"--}}
                                            {{--                                       data-bs-target="#modalModal"--}}
                                            {{--                                       data-loader="{{$materia->id}}"--}}
                                            {{--                                       data-attr="{{ route('ciclo_lectivo_especial.create', $materia) }}">--}}
                                            {{--                                        <i class="fas fa-edit text-gray-300"></i>--}}
                                            {{--                                        <i class="fa fa-spinner fa-spin" style="display: none"--}}
                                            {{--                                           id="loader{{$materia->id}}"></i>--}}
                                            {{--                                    </a>--}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <h3 class="text-secondary">Segundo Año</h3>
                        <table class="table table-hover mt-4">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Materia</th>
                                <th scope="col" class="text-center"><i class="fa fa-cog" style="font-size:20px;"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($materias as $materia)
                                @if($materia->año == 2)
                                    <tr style="cursor:pointer;">
                                        <td>{{ $materia->nombre }}</td>
                                        <td>
                                            @if(Auth::user()->hasRole('regente') || Auth::user()->hasRole('coordinador') || Auth::user()->hasRole('seccionAlumnos') || Auth::user()->hasRole('admin'))
                                                <a href="{{ route('materia.editar',['id'=>$materia->id]) }}"
                                                   class="btn btn-sm btn-warning">Editar</a>
                                            @endif
                                            <a href="{{ route('calificacion.admin',['materia_id'=>$materia->id,'ciclo_lectivo'=>date('Y')]) }}"
                                               class="btn btn-sm btn-secondary">Ver calificaciones</a>
                                            <a href="{{ route('descargar_planilla',$materia->id) }}"
                                               class="btn btn-sm btn-success"><i
                                                    class="fas fa-download"></i> Descargar Alumnos</a>
                                            <sup class="badge badge-info" title="Total Comisiones">
                                                {{$materia->getTotalAttribute()}}
                                                @if($materia->getTotalAttribute() > 0)
                                                    <a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @endif
                                            </sup>
                                            {{--                                    <a class="btn btn-sm btn-info" data-bs-toggle="modal" id="agregarButton"--}}
                                            {{--                                       data-bs-target="#modalModal"--}}
                                            {{--                                       data-loader="{{$materia->id}}"--}}
                                            {{--                                       data-attr="{{ route('ciclo_lectivo_especial.create', $materia) }}">--}}
                                            {{--                                        <i class="fas fa-edit text-gray-300"></i>--}}
                                            {{--                                        <i class="fa fa-spinner fa-spin" style="display: none"--}}
                                            {{--                                           id="loader{{$materia->id}}"></i>--}}
                                            {{--                                    </a>--}}

                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <h3 class="text-secondary">Tercer Año</h3>
                        <table class="table table-hover mt-4">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Materia</th>
                                <th scope="col" class="text-center"><i class="fa fa-cog" style="font-size:20px;"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($materias as $materia)
                                @if($materia->año == 3)
                                    <tr style="cursor:pointer;">
                                        <td>{{ $materia->nombre }}</td>
                                        <td>
                                            @if(Auth::user()->hasRole('regente') || Auth::user()->hasRole('coordinador') || Auth::user()->hasRole('seccionAlumnos') || Auth::user()->hasRole('admin'))
                                                <a href="{{ route('materia.editar',['id'=>$materia->id]) }}"
                                                   class="btn btn-sm btn-warning">Editar</a>
                                            @endif
                                            <a href="{{ route('calificacion.admin',['materia_id'=>$materia->id,'ciclo_lectivo'=>date('Y')]) }}"
                                               class="btn btn-sm btn-secondary">Ver calificaciones</a>
                                            <a href="{{ route('descargar_planilla',$materia->id) }}"
                                               class="btn btn-sm btn-success"><i
                                                    class="fas fa-download"></i> Descargar Alumnos</a>

                                            <sup class="badge badge-info" title="Total Comisiones">
                                                {{$materia->getTotalAttribute()}}

                                                @if($materia->getTotalAttribute() > 0)

                                                    <a href="{{ route('comisiones.ver',$carrera->id)}}/?año={{$materia->año}}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                @endif
                                            </sup>
                                            {{--                                <a class="btn btn-sm btn-info" data-bs-toggle="modal" id="agregarButton"--}}
                                            {{--                                   data-bs-target="#modalModal"--}}
                                            {{--                                   data-loader="{{$materia->id}}"--}}
                                            {{--                                   data-attr="{{ route('ciclo_lectivo_especial.create', $materia) }}">--}}
                                            {{--                                    <i class="fas fa-edit text-gray-300"></i>--}}
                                            {{--                                    <i class="fa fa-spinner fa-spin" style="display: none"--}}
                                            {{--                                       id="loader{{$materia->id}}"></i>--}}
                                            {{--                                </a>--}}


                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{url()->previous()}}">
                        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @include('comision.modals.crear_comision')
    {{--    @include('parameters.ciclo_lectivo.modal.form_modal_ciclo_lectivo')--}}
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
