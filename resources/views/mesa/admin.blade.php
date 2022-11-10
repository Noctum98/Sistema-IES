@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h1 text-info">
            Administrar instancias de mesas
        </h2>
        <hr>
        @if(Auth::user()->rol == 'rol_admin')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Crear Instancia
            </button>
        @endif
        @if(@session('mensaje'))
            <div class="alert alert-success mt-3">
                {{@session('mensaje')}}
            </div>
        @endif
        <!-- Modal Crear-->
        @include('mesa.modals.crear_instancia')
        @if(count($instancias) != 0)
            <div class="table-responsive">
                <table class="table mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                        <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                        @if(Session::has('admin'))
                            <th scope="col">Inactiva/Activa</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($instancias as $instancia)
                        <tr style="cursor:pointer;">
                            <td><b>{{ $instancia->nombre }}</b></td>
                            <td><b>{{ $instancia->tipo == 0 ? 'Común' : 'Especial' }}</b></td>
                            <td>
                                <button type="button" class="btn-sm btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#modal{{$instancia->id}}">
                                    Ver Inscripciones
                                </button>
                                @if(Session::has('admin'))
                                    <button type="button" class="btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#edit{{$instancia->id}}">
                                        Editar Mesa
                                    </button>
                                    @if($instancia->tipo == 0)
                                        <button type="button" class="btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete{{$instancia->id}}">
                                            Borrar datos
                                        </button>
                                    @else
                                        <a href="{{route('borrar_datos',['id'=>$instancia->id])}}" type="button"
                                           class="btn btn-sm btn-danger">
                                            Borrar datos
                                        </a>
                                    @endif

                                    <a class="btn btn-sm btn-success" data-bs-toggle="modal"
                                       data-bs-target="#vistaSeleccionCarrera" id="vistaCarrera"
                                       data-loader="{{$instancia->id}}"
                                       data-attr="{{ route('carrera.vista_carrera', ['instancia' => $instancia->id]) }}">
                                        <i class="fa fa-spinner fa-spin" style="display: none"
                                           id="loader{{$instancia->id}}"></i>
                                        Carreras PDF
                                    </a>
                                    @include('mesa.modals.vista_seleccion_carreras')
                                    <a class="btn btn-sm btn-success" data-bs-toggle="modal"
                                       data-bs-target="#vistaSeleccionMateria" id="vistaMateria"
                                       data-loader="{{$instancia->id}}-materia"
                                       data-attr="{{ route('materia.vista_materia', ['instancia' => $instancia->id]) }}">
                                        <i class="fa fa-spinner fa-spin" style="display: none"
                                           id="loader{{$instancia->id}}"></i>
                                        Acta Volante
                                    </a>
                                    @include('mesa.modals.vista_seleccion_materia')
                                @endif
                            </td>
                            @if(Session::has('admin'))
                                <td>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input switchinsta"
                                               value="{{$instancia->estado}}"
                                               id="{{$instancia->id}}" {{$instancia->estado == 'activa' ? 'checked':''}}>
                                        <label class="custom-control-label" for="{{$instancia->id}}"></label>
                                    </div>
                                </td>
                            @endif
                        </tr>
                        <!--Modal Ver-->
                        @include('mesa.modals.ver_inscripciones')
                        <!--Modal Editar-->
                        @include('mesa.modals.editar_instancia')
                        <!--Modal Borrar-->
                        @include('mesa.modals.borrar_instancia')
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No existen instancias creadas</p>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '#vistaCarrera', function (event) {
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
                    $('#vistaSeleccionCarrera').modal("show");
                    $('#vistaSeleccionCarreraBody').html(result).show();
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 16000
            })
        });

        $(document).on('click', '#vistaMateria', function (event) {
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
                    $('#vistaSeleccionMateria').modal("show");
                    $('#vistaSeleccionMateriaBody').html(result).show();
                },
                complete: function () {
                    $laoder.hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 16000
            })
        });
    </script>
@endsection