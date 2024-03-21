@extends('layouts.app-prueba')
@section('content')
    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-light">
        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0 card-title">Condición Carreras</h4>
            <div>
                <a href="{{ route('condicion_carreras.condicion_carrera.create') }}" class="btn btn-secondary"
                   title="Crear nueva Condición Carrera">
                    <span class="fa fa-plus" aria-hidden="true"></span>
                    Crear
                </a>
            </div>
        </div>

        @if(count($condicionCarreras) == 0)
            <div class="card-body text-center">
                <h4>No hay condiciones de carreras disponibles.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Identificador</th>
                            <th>Habilitado</th>
                            <th>Operador</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($condicionCarreras as $condicionCarrera)
                            <tr>
                                <td class="align-middle">{{ $condicionCarrera->nombre }}</td>
                                <td class="align-middle">{{ $condicionCarrera->identificador }}</td>
                                <td class="align-middle">
                                    @if($condicionCarrera->habilitado)
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="align-middle">{{ optional($condicionCarrera->operador)->getApellidoNombre() }}</td>
                                <td class="text-end">
                                    <form method="POST"
                                          action="{!! route('condicion_carreras.condicion_carrera.destroy', $condicionCarrera->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('condicion_carreras.condicion_carrera.show', $condicionCarrera->id ) }}"
                                               class="btn btn-info" title="Ver Condición Carrera">
                                                <i class="fa fa-eye"></i>
                                                Ver
                                            </a>
                                            <a href="{{ route('condicion_carreras.condicion_carrera.edit', $condicionCarrera->id ) }}"
                                               class="btn btn-primary" title="Editar Condición Carrera">
                                                <span class="fa fa-pen" aria-hidden="true"></span>
                                                Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger"
                                                    title="Borrar Condición Carrera"
                                                    onclick="return confirm(&quot;Aceptar para borrar Condición Carrera.&quot;)">
                                                <span class="fa fa-trash" aria-hidden="true"></span>
                                                Borrar
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $condicionCarreras->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
