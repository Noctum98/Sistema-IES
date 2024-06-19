@extends('layouts.app-prueba')
<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('content')
<div class="container">
    <h2 class="h1 text-info">
        Administrar instancias de mesas
    </h2>
    <hr>
    @if(Session::has('admin') || Session::has('regente'))
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
    <!--Modal Editar-->
    @include('mesa.modals.editar_instancia')

    @if($todos)
    <br>
    <a href="{{ route('mesa.admin') }}" class="mt-3 btn btn-sm btn-info"><i class="fas fa-eye"></i> Ver menos</a>
    @endif

    @if(count($instancias) != 0)
    <div class="table-responsive">
        <table class="table mt-4">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Año</th>
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                    @if(Session::has('admin') || Session::has('regente'))
                    <th scope="col">Inhabilitar/Habilitar Mesa</th>
                    <th scope="col">Inhabilitar/Habilitar Bajas</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($instancias as $instancia)
                <tr style="cursor:pointer;">
                    <td><b>{{ $instancia->nombre }}</b></td>
                    <td><b>{{ $instancia->tipo == 0 ? 'Común' : 'Especial' }}</b></td>
                    <td><b class="text-primary">{{ $instancia->año }}</b></td>
                    <td>
                        <button type="button" class="btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modal{{$instancia->id}}">
                            Ver Inscripciones
                        </button>
                        @if(Session::has('admin') || Session::has('regente'))
                        <button type="button" class="btn-sm btn-warning open_modal" data-instancia_id="{{ $instancia->id }}" data-bs-toggle="modal" data-bs-target="#edit">
                            Editar Instancia
                        </button>
                        <a href="{{ route('mesas.resumen',$instancia->id) }}" class="btn btn-sm btn-light">Ver Informe</a>
                        @endif
                        @if(Session::has('admin') || Session::has('coordinador') || Session::has('regente'))
                        <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#vistaSeleccionMateria" id="vistaMateria" data-loader="{{$instancia->id}}-materia" data-attr="{{ route('materia.vista_materia', ['instancia' => $instancia->id]) }}">
                            <i class="fa fa-spinner fa-spin" style="display: none" id="loader{{$instancia->id}}"></i>
                            Acta Volante
                        </a>
                        @include('mesa.modals.vista_seleccion_materia')
                        <a class="btn btn-sm btn-success" href="{{ route('mesa.cronograma', ['instancia_id' => $instancia->id]) }}" {{--                                       data-bs-target="#vistaSeleccionCarrera" id="vistaCarrera"--}} data-loader="{{$instancia->id}}" data-attr="{{ route('mesa.cronograma', ['instancia_id' => $instancia->id]) }}">
                            <i class="fa fa-spinner fa-spin" style="display: none" id="loader{{$instancia->id}}"></i>
                            Ver cronograma
                        </a>
                        @include('mesa.modals.vista_seleccion_carreras')
                        @endif
                    </td>
                    @if(Session::has('admin'))
                    <td>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input switchinsta" value="{{$instancia->estado}}" id="{{$instancia->id}}" {{$instancia->estado == 'activa' ? 'checked':''}}>
                            <label class="custom-control-label" for="{{$instancia->id}}"></label>
                        </div>
                    </td>

                    <td>

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input switchinstacierre" value="{{$instancia->cierre}}" id="cierre-{{$instancia->id}}" data-instancia_id="{{$instancia->id}}" {{$instancia->cierre ? 'checked':''}}>
                            <label class="custom-control-label" for="cierre-{{$instancia->id}}"></label>
                        </div>
                    </td>
                    @endif
                </tr>
                <!--Modal Ver-->
                @include('mesa.modals.ver_inscripciones')

                <!--Modal Borrar-->
                @include('mesa.modals.borrar_instancia')
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>No existen instancias creadas</p>
    @endif

    @if(!$todos)
    <a href="{{ route('mesa.admin',['todos'=>true]) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Ver todos</a>
    @endif

</div>
@endsection
@section('scripts')
<script src="{{asset('vendors/select2/js/select2.min.js')}}"></script>
<script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>
<script>
    $(document).on('click', '#vistaCarrera', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        let referencia = $(this).attr('data-loader');
        const $laoder = $('#loader' + referencia);


        $.ajax({
            url: href,
            beforeSend: function() {
                $laoder.show();
            },
            // return the result
            success: function(result) {
                $('#vistaSeleccionCarrera').modal("show");
                $('#vistaSeleccionCarreraBody').html(result).show();
            },
            complete: function() {
                $laoder.hide();
            },
            error: function(jqXHR, testStatus, error) {
                $laoder.hide();
            },
            timeout: 16000
        })
    });

    $(document).on('click', '#vistaMateria', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        let referencia = $(this).attr('data-loader');
        const $laoder = $('#loader' + referencia);

        $.ajax({
            url: href,
            beforeSend: function() {
                $laoder.show();
            },
            // return the result
            success: function(result) {
                $('#vistaSeleccionMateria').modal("show");
                $('#vistaSeleccionMateriaBody').html(result).show();
            },
            complete: function() {
                $laoder.hide();
            },
            error: function(jqXHR, testStatus, error) {
                console.log(error);

                $laoder.hide();
            },
            timeout: 16000
        })
    });
</script>
<script src="{{ asset('js/mesas/instancias.js') }}"></script>

@endsection
