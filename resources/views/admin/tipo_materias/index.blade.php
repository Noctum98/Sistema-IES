@extends('layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Tipo Materias</h4>
            <div>
                <a href="{{ route('tipo_materias.tipo_materia.create') }}" class="btn btn-secondary"
                   title="Agregar Tipo Materia">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($tipoMaterias) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Tipo Materias.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Identificador</th>
                            <th>Nombre</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tipoMaterias as $tipoMateria)
                            <tr>
                                <td class="align-middle">{{ $tipoMateria->identificador }}</td>
                                <td class="align-middle">{{ $tipoMateria->nombre }}</td>

                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('tipo_materias.tipo_materia.destroy', $tipoMateria->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('tipo_materias.tipo_materia.show', $tipoMateria->id ) }}"
                                               class="btn btn-info" title="Ver Tipo Materia">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span>
                                            </a>
                                            <a href="{{ route('tipo_materias.tipo_materia.edit', $tipoMateria->id ) }}"
                                               class="btn btn-primary" title="Editar Tipo Materia">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Tipo Materia"
                                                    onclick="return confirm('Aceptar para borrar Tipo Materia')">
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

                {!! $tipoMaterias->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
