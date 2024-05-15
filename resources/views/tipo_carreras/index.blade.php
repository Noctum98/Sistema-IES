@extends('layouts.app-prueba')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">
        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Tipo Carreras</h4>
            <div>
                <a href="{{ route('tipo_carreras.tipo_carrera.create') }}" class="btn btn-secondary"
                   title="Crear Tipo Carrera">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Nueva
                </a>
            </div>
        </div>

        @if(count($tipoCarreras) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Tipo Carreras.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Identificador</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tipoCarreras as $tipoCarrera)
                            <tr>
                                <td class="align-middle">{{ $tipoCarrera->name }}</td>
                                <td class="align-middle">{{ $tipoCarrera->identifier }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('tipo_carreras.tipo_carrera.destroy', $tipoCarrera->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('tipo_carreras.tipo_carrera.show', $tipoCarrera->id ) }}"
                                               class="btn btn-info" title="Ver Tipo Carrera">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span>
                                            </a>
                                            <a href="{{ route('tipo_carreras.tipo_carrera.edit', $tipoCarrera->id ) }}"
                                               class="btn btn-primary" title="Editar Tipo Carrera">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Borrar Tipo Carrera"
                                                    onclick="return confirm(&quot;Click Ok para borrar Tipo Carrera.&quot;)">
                                                <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $tipoCarreras->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
