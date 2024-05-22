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
            <h4 class="m-0">Master Materias</h4>
            <div>
                <a href="{{ route('master_materias.master_materia.create') }}" class="btn btn-secondary"
                   title="Crear  Master Materia">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($masterMaterias) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Master Materias.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Año</th>
                            <th>Etapa Campo</th>
                            <th>Cierre Diferido</th>
                            <th>Resolución</th>
                            <th>Régimen</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($masterMaterias as $masterMateria)
                            <tr>
                                <td class="align-middle">{{ $masterMateria->name }}</td>
                                <td class="align-middle">{{ $masterMateria->year }}</td>
                                <td class="align-middle">{{ ($masterMateria->field_stage) ? 'Si' : 'No' }}</td>
                                <td class="align-middle">{{ ($masterMateria->delayed_closing) ? 'Si' : 'No' }}</td>
                                <td class="align-middle">{{ optional($masterMateria->resoluciones)->name }}</td>
                                <td class="align-middle">{{ optional($masterMateria->regimen)->name }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('master_materias.master_materia.destroy', $masterMateria->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('master_materias.master_materia.show', $masterMateria->id ) }}"
                                               class="btn btn-info" title="Ver Master Materia">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span>
                                            </a>
                                            <a href="{{ route('master_materias.master_materia.edit', $masterMateria->id ) }}"
                                               class="btn btn-primary" title="Editar Master Materia">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Borrar Master Materia"
                                                    onclick="return confirm(&quot;Click Ok para borrar Master Materia.&quot;)">
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

                {!! $masterMaterias->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
