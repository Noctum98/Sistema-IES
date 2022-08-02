@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <a href="{{url()->previous()}}">
            <button class="btn btn-outline-info mb-2">
                <i class="fas fa-angle-left"></i>
                Volver
            </button>
        </a>
        <h2 class="h1 text-info">Configurar Cargo</h2>
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
            <p>No hay módulos vinculadas al cargo.</p>
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
                        <td>{{ $materia->nombre }}</td>
                        <td>
                            <form action="" id="pondera-cargo-materia" class="pondera-cargo">
                                <input type="number" style="width: 50%" class="form-control ponderacion_cargo_materia
{{--                        @if($proceso->cierre || !$proceso->estado_id) disabled @endif--}}
                        "
                                       id="ponderacion" value="{{$cargo->ponderacion($cargo->id,$materia->id)??'0' }}"/>
                                <input type="hidden" id="cargo" value="{{$cargo->id}}"/>
                                <input type="hidden" id="materia" value="{{$materia->id}}"/>
                                <button type="submit" style="width: 50%" class="btn btn-info btn-sm input-group-text
                        @if(!Session::has('coordinador') && !Session::has('admin') ) disabled @endif
                        ">
                                    <i class="fa fa-save"></i></button>
                            </form>

                        </td>
                        <td>
                            <i class="fa fa-spinner fa-spin" style="display: none"
                               id="loader-cargo-{{$cargo->id}}-materia-{{$materia->id}}"></i>
                            <div id="cargo-{{$cargo->id}}-materia-{{$materia->id}}">{{$materia->totalModulo()}}</div>
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
                    <th scope="col">cargo</th>
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
                                {{$cargo_materia->materia->nombre}}<br/>
                            @endforeach
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#agregarCargoModulo"
                                        id="formAgregar"
                                        data-loader="{{$usuario->id}}"
                                        data-attr="{{ route('modulo_profesor.form_agregar_cargo_modulo', ['cargo' => $cargo->id, 'usuario' => $usuario->id]) }}">
                                    <i class="fa fa-spinner fa-spin" style="display: none"
                                       id="loader{{$usuario->id}}"></i>

                                    Vincular Cargo-Modulo
                                </a>
                                @include('cargo.modals.agregar_cargo-modulo')

                        </td>
                        <td>{{$cargo->id}}</td>
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
    <script>

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
    </script>
@endsection