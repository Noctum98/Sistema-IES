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
            <h4 class="m-0">Correlatividades Agrupadas</h4>
            <div>
                <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.create') }}"
                   class="btn btn-secondary" title="Agregar Correlatividad Agrupada">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($correlatividadAgrupadas) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron correlatividades agrupadas.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Deshabilitada</th>
                            <th>Identificador</th>
                            <th>Nombre</th>
                            <th>Resolución Nro: </th>
                            <th>Operador</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($correlatividadAgrupadas as $correlatividadAgrupada)
                            <tr>
                                <td class="align-middle">{{ ($correlatividadAgrupada->Disabled) ? 'Si' : 'No' }}</td>
                                <td class="align-middle">{{ $correlatividadAgrupada->Identifier }}</td>
                                <td class="align-middle">{{ $correlatividadAgrupada->Name }}</td>
                                <td class="align-middle">{{ optional($correlatividadAgrupada->Resoluciones)->name }}</td>
                                <td class="align-middle">{{ optional($correlatividadAgrupada->user)->getApellidoNombre() }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('correlatividad_agrupadas.correlatividad_agrupada.destroy', $correlatividadAgrupada->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.show', $correlatividadAgrupada->id ) }}"
                                               class="btn btn-info" title="Ver Correlatividad Agrupada">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.edit', $correlatividadAgrupada->id ) }}"
                                               class="btn btn-primary" title="Editar Correlatividad Agrupada">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger"
                                                    title="Borrar Correlatividad Agrupada"
                                                    onclick="return confirm('Click para borrar Correlatividad Agrupada.')">
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

                {!! $correlatividadAgrupadas->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
