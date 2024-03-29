@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <a href="{{ route('cargo.admin') }}">
            <button class="btn btn-outline-info mb-2">
                <i class="fas fa-angle-left"></i>
                Volver
            </button>
        </a>
        <h3 class="text-info">Configurar Cargo</h3>
        <hr>
        <p><i>{{ $cargo->nombre.' - '.$cargo->carrera->nombre.' ( '.$cargo->carrera->sede->nombre.' )' }}</i></p>
        <h3 class="text-secondary mb-3">Módulos</h3>
        <p>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#agregarModulo">Agregar
                módulo
            </button>
        </p>
        @include('cargo.modals.agregar_modulo')
        @if(count($cargo->materias) == 0)
            <p>No hay módulos vinculados al cargo.</p>
        @else

            <table class="table mt-4">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Ponderación Cargo</th>
                    <th scope="col">Ponderación total módulo</th>
                    <th scope="col">
                        <i class="fa fa-cog" style="font-size:20px;"></i>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cargo->materias as $materia)
                    <tr>
                        <th scope="row">{{ $materia->id }}</th>
                        <td>
                            <a href="{{route('modulos.ver', ['materia' => $materia->id])}}"
                               title="Ver módulo">
                                {{$materia->nombre}}
                            </a>
                        </td>
                        <td>
                            @if(!$cargo->ponderacion($materia->id))
                                <form action="" id="pondera-cargo-materia" class="pondera-cargo">
                                    <input type="number" style="width: 50%" class="form-control ponderacion_cargo_materia
{{--                        @if($proceso->cierre || !$proceso->estado_id) disabled @endif--}}
                        "
                                           id="ponderacion" value="{{$cargo->ponderacion($materia->id)??'0' }}"/>
                                    <input type="hidden" id="cargo" value="{{$cargo->id}}"/>
                                    <input type="hidden" id="materia" value="{{$materia->id}}"/>
                                    <button type="submit" style="width: 50%" class="btn btn-info btn-sm input-group-text
                        @if(!Session::has('coordinador') && !Session::has('admin') ) disabled @endif
                        ">
                                        <i class="fa fa-save"></i></button>
                                </form>
                            @else
                                {{$cargo->ponderacion($materia->id)}}
                            @endif

                        </td>
                        <td>
                            <i class="fa fa-spinner fa-spin" style="display: none"
                               id="loader-cargo-{{$cargo->id}}-materia-{{$materia->id}}"></i>
                            <a href="{{route('modulos.ver', ['materia' => $materia->id])}}"
                               title="Ver módulo" class="text-info btn-sm d-inline">
                                <i class="fa fa-edit"></i>
                            </a>
                            <div class="d-inline"
                                 id="cargo-{{$cargo->id}}-materia-{{$materia->id}}">{{$materia->totalModulo()}}</div>
                        </td>

                        <td>
                            <form action="{{ route('cargo.delMateria',$cargo->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="materia_id" value="{{$materia->id}}">
                                <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif


        <h3 class="text-secondary mb-3">Usuarios</h3>
        <p>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#agregarUser">
                Agregar usuario
            </button>
        </p>
        @include('cargo.modals.agregar_user')

        @if(count($cargo->users) == 0)
            <p>No hay usuarios vinculados al cargo.</p>
        @else

            <table class="table mt-4">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Módulo</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">
                        <i class="fa fa-cog" style="font-size:20px;"></i>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cargo->users as $usuario)
                    <tr>
                        <th scope="row">{{ $usuario->id }}</th>
                        <td>{{ $usuario->nombre.' '.$usuario->apellido }}</td>
                        <td>
                            @foreach($usuario->cargo_materia()->get() as $cargo_materia)

                                <small>({{$cargo_materia->cargo()->first()->nombre}})</small>
                                <b>{{$cargo_materia->materia->nombre}}</b>
                                <small>{{$cargo_materia->materia->carrera()->first()->nombre}}</small>
                                <small >
                                    <form action="{{ route('modulo_profesor.destroy',['materia' => $cargo_materia->materia->id, 'cargo' => $cargo_materia->cargo()->first()->id, 'user' => $usuario->id] ) }}" method="POST"
                                          class="d-inline-block"
                                    >
                                        {{ method_field('DELETE') }}
                                        <input type="submit" value="X" class="btn btn-sm btn-danger py-0 px-1">
                                    </form>
                                </small>

                                <br/>
                            @endforeach
                            <a class="btn btn-sm btn-success" data-bs-toggle="modal"
                               data-bs-target="#agregarCargoModulo"
                               id="formAgregar"
                               data-loader="{{$usuario->id}}"
                               data-attr="{{ route('modulo_profesor.form_agregar_cargo_modulo', ['cargo' => $cargo->id, 'usuario' => $usuario->id]) }}">
                                <i class="fa fa-spinner fa-spin" style="display: none"
                                   id="loader{{$usuario->id}}"></i>

                                Vincular Cargo-Modulo
                            </a>
                            @include('cargo.modals.agregar_cargo-modulo')

                        </td>
                        <td>{{$cargo->nombre}}</td>
                        <td>
                            <form action="{{ route('cargo.delUser',$cargo->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="user_id" value="{{$usuario->id}}">
                                <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/user/carreras.js') }}"></script>
    <script src="{{ asset('js/cargos/pondera.js') }}"></script>
    <script src="{{ asset('vendors/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(".carreras").select2({
                dropdownParent: $('#agregarUser'),
                width: "100%"
            });
        });
        $(document).ready(function () {
            $("#materia_id").select2({
                // dropdownParent: $('#agregarCargoModulo'),
                width: "100%"
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
                timeout: 15000
            })
        });
    </script>
@endsection