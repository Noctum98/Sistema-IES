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
            <h4 class="m-0">Notas en folio</h4>
            <div>
                <a href="{{ route('folio_notas.folio_nota.create') }}" class="btn btn-secondary"
                   title="Agregar Nota">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($folioNotas) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron nota s de folio disponibles.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Orden</th>
                            <th>Permiso</th>
                            <th>Alumno</th>
                            <th>Escrito</th>
                            <th>Oral</th>
                            <th>Calificación Definitiva</th>
                            <th>Operador</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($folioNotas as $folioNota)
                            <tr>
                                <td class="align-middle">
                                    {{ optional($folioNota->MesaFolio)->libro() }}
                                    / {{ optional($folioNota->MesaFolio)->numero }}
                                </td>
                                <td class="align-middle">{{ $folioNota->orden }}</td>
                                <td class="align-middle">{{ $folioNota->permiso }}</td>
                                <td class="align-middle">
                                    {{ optional($folioNota->Alumno)->dni }}
                                    {{ optional($folioNota->Alumno)->getApellidosNombres() }}
                                </td>
                                <td class="align-middle">{{ $folioNota->escrito }}</td>
                                <td class="align-middle">{{ $folioNota->oral }}</td>
                                <td class="align-middle">{{ $folioNota->definitiva }}</td>

                                <td class="align-middle">{{ optional($folioNota->User)->getApellidoNombre() }}</td>


                                <td class="text-end">

                                    <form method="POST"
                                          action="{!! route('folio_notas.folio_nota.destroy', $folioNota->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('folio_notas.folio_nota.show', $folioNota->id ) }}"
                                               class="btn btn-info" title="Ver detalles de nota">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('folio_notas.folio_nota.edit', $folioNota->id ) }}"
                                               class="btn btn-primary" title="Editar Nota">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                                Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Folio Nota"
                                                    onclick="return confirm('Aceptar para eliminar la nota')">
                                                <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                                                Eliminar
                                            </button>
                                        </div>

                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $folioNotas->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
