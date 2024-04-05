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
            <h4 class="m-0">Materias Correlativas Cursado</h4>
            <div>
                <a href="{{ route('materias_correlativas_cursados.materias_correlativas_cursado.create') }}"
                   class="btn btn-secondary" title="Crear Nueva Materias Correlativas Cursado">
                    <span class="fa fa-plus" aria-hidden="true"> </span> Agregar
                </a>
            </div>
        </div>

        @if(count($materiasCorrelativasCursados) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Materias Correlativas Cursados.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Previa</th>
                            <th>Operador</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($materiasCorrelativasCursados as $materiasCorrelativasCursado)
                            <tr>
                                <td class="align-middle">{{ $materiasCorrelativasCursado->materia->nombre }}</td>
                                <td class="align-middle">{{ $materiasCorrelativasCursado->previa->nombre }}</td>
                                <td class="align-middle">{{ $materiasCorrelativasCursado->operador->getApellidoNombre() }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('materias_correlativas_cursados.materias_correlativas_cursado.destroy', $materiasCorrelativasCursado->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('materias_correlativas_cursados.materias_correlativas_cursado.show', $materiasCorrelativasCursado->id ) }}"
                                               class="btn btn-info" title="Ver Materias Correlativas Cursado">
                                                <span class="fa fa-arrow-up"
                                                      aria-hidden="true"></span> Ver correlativas de cursado
                                            </a>
                                            <a href="{{ route('materias_correlativas_cursados.materias_correlativas_cursado.edit', $materiasCorrelativasCursado->id ) }}"
                                               class="btn btn-primary" title="Editar Materias Correlativas Cursado">
                                                <span class="fa fa-pen" aria-hidden="true"></span> Editar
                                                Materias Correlativas Cursado
                                            </a>

                                            <button type="submit" class="btn btn-danger"
                                                    title="Borrar Materias Correlativas Cursado"
                                                    onclick="return confirm(&quot;Click en Aceptar para borrar Materias Correlativas Cursado.&quot;)">
                                                <span class="fa fa-trash" aria-hidden="true"></span> Borrar
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $materiasCorrelativasCursados->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
