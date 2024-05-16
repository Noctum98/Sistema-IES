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
            <h4 class="m-0">Resoluciones Carreras</h4>
            <div>
                <a href="{{ route('resoluciones.resoluciones.create') }}" class="btn btn-secondary"
                   title="Crear Resolución">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Nueva
                </a>
            </div>
        </div>

        @if(count($resolucionesObjects) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Resoluciones Carreras Disponibles.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Título</th>
                            <th>Duración</th>
                            <th>Resolución nro.</th>
                            <th>Modalidad</th>
                            <th>Vacunas</th>
                            <th>Tipo Carrera</th>
                            <th>Estado</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($resolucionesObjects as $resoluciones)
                            <tr>
                                <td class="align-middle">{{ $resoluciones->name }}</td>
                                <td class="align-middle">{{ $resoluciones->title }}</td>
                                <td class="align-middle">{{ $resoluciones->duration }}</td>
                                <td class="align-middle">{{ $resoluciones->resolution }}</td>
                                <td class="align-middle">{{ $resoluciones->modality }}</td>
                                <td class="align-middle">{{ $resoluciones->vaccines }}</td>
                                <td class="align-middle">{{ optional($resoluciones->TipoCarrera)->name }}</td>
                                <td class="align-middle">{{ optional($resoluciones->EstadoResoluciones)->name }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('resoluciones.resoluciones.destroy', $resoluciones->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('resoluciones.resoluciones.show', $resoluciones->id ) }}"
                                               class="btn btn-info" title="Ver Resoluciones">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span>
                                            </a>
                                            <a href="{{ route('resoluciones.resoluciones.edit', $resoluciones->id ) }}"
                                               class="btn btn-primary" title="Editar Resolución">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Borrar Resoluciones"
                                                    onclick="return confirm(&quot;Click Ok para borrar Resolución.&quot;)">
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

                {!! $resolucionesObjects->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
