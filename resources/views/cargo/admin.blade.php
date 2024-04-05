@extends('layouts.app-prueba')
<link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet">

<link rel="stylesheet"
      href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css')}}"
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
@section('content')
    <div class="container-fluid">
        @if(@session('cargo_deleted'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </symbol>
            </svg>
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                <div>
                    {{ @session('cargo_deleted') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h4 class="text-info">Cargos
        </h4>

        <h6>
            <i>Administrar Cargos</i>
        </h6>
        <hr>

        <form action="{{ route('cargo.admin') }}" class="d-none row m-1" id="form_filtros">
            <input type="hidden" name="busqueda" value="1">
            <h5>Filtrar por:</h5>
            <div class="form-group col-sm-6 col-md-4">
                <label for="carrera_id">Carrera:</label>
                <select name="carrera_id" id="carrera_id" class="form-control selector">
                    <option value="todos">Todos</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6 col-md-4">
                <label for="sede_id">Sede:</label>
                <select name="sede_id" id="sede_id" class="form-control selector">
                    <option value="todos">Todas</option>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6 col-md-4">
                <label for="search">Nombre</label>
                <input class="form-control" type="text" id="search" name="nombre" placeholder="Nombre">
            </div>
            <div class="form-group col-2 mx-auto">
            <input type="submit" value="Buscar" class="btn btn-sm btn-primary">
            </div>

        </form>

        @if(Session::has('admin'))
            <p>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearCargo">Crear Cargo</button>
                @if(Session::has('admin') || Session::has('regente'))
                    <button class="btn btn-primary" id="filtros">Filtros</button>
                @endif

            </p>

            @include('cargo.modals.crear_cargo')
        @endif

        @if(count($cargos) > 0)
            <div class="table-responsive">

                <table class="table mt-4">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="col-4">Módulos</th>
                        <th scope="col">Carrera</th>
                        <th scope="col" class="text-center">
                            <i class="fa fa-cog" style="font-size:20px;"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cargos as $cargo)
                        <tr>
                            <th scope="row">{{ $cargo->id }}</th>
                            <td>{{ $cargo->nombre }}</td>
                            <td>
                                @if(count($cargo->materias) > 0)
                                    @foreach($cargo->materias as $materia)
                                        <div class="m-2 p-3 border border-bottom border-dark">
                                            -
                                            @if(Auth::user()->hasRole('admin'))
                                                <small>({{$materia->id}})</small>
                                            @endif
                                            <a href="{{route('modulos.ver', ['materia' => $materia->id])}}"
                                               title="Ver módulo">
                                                {{$materia->nombre}}
                                            </a>
                                            <small
                                                class="float-end"> x̄: {{$cargo->ponderacion($materia->id)??'0'}}
                                                %</small>
                                        </div>

                                    @endforeach
                                @else
                                    No se encontraron módulos asociados.
                                @endif

                            </td>
                            <td >
                                <b>{{ $cargo->carrera->nombre}}</b> <br/> <small class="float-end"><i>{{$cargo->carrera->sede->nombre }}</i></small>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('cargo.show',$cargo->id) }}"
                                   class="btn btn-sm btn-primary block-inline ">Configurar</a>
                                <a href="{{ route('cargo.edit',$cargo->id) }}"
                                   class="btn btn-sm btn-warning ">Editar</a>
                                <form method="POST" class="d-inline"
                                      action="{{route('cargo.delete', ['cargo' => $cargo->id])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Se borrará el registro. ¿Confirma?.')"
                                            type="submit"> Borrar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <h4 class="text-secondary">No existen cargos creados</h4>
        @endif
        <div class="d-flex justify-content-center" style="font-size: 0.8em">
            {{ $cargos->links() }}
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/listados/filtros.js') }}"></script>
    <script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $('#carrera_id').select2({
                width: "100%",
                theme: "classic",
                clear: true,
                placeholder: "Todos"
            });

            $('#sede_id').select2({
                width: "100%",
                theme: "classic",
                clear: true,
                placeholder: "Todos"
            });

        });
    </script>
@endsection
