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
            <h4 class="m-0">Materias agrupadas</h4>
            <div>
                <a href="{{ route('agrupada_materias.agrupada_materia.create') }}" class="btn btn-secondary"
                   title="Agregar Materia">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($agrupadaMaterias) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron materias agrupadas.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Correlatividad Agrupada</th>
                            <th>Deshabilitada</th>
                            <th>Materia</th>
                            <th>Operador</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($agrupadaMaterias as $agrupadaMateria)
                            <tr>
                                <td class="align-middle">{{ optional($agrupadaMateria->CorrelatividadAgrupada)->Name }}</td>
                                <td class="align-middle">{{ ($agrupadaMateria->disabled) ? 'Si' : 'No' }}</td>
                                <td class="align-middle">{{ optional($agrupadaMateria->MasterMateria)->name }}</td>
                                <td class="align-middle">{{ optional($agrupadaMateria->user)->activo }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('agrupada_materias.agrupada_materia.destroy', $agrupadaMateria->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('agrupada_materias.agrupada_materia.show', $agrupadaMateria->id ) }}"
                                               class="btn btn-info" title="Ver Materia Agrupada">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('agrupada_materias.agrupada_materia.edit', $agrupadaMateria->id ) }}"
                                               class="btn btn-primary" title="Editar  Materia Agrupada">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Borrar Materia Agrupada"
                                                    onclick="return confirm('Click Ok para eliminar  Materia Agrupada.')">
                                                <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Borrar
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $agrupadaMaterias->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
