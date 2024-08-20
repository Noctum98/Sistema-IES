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
            <h4 class="m-0">Folios (Mesas)</h4>
            <div>
                <a href="{{ route('mesa_folios.mesa_folio.create') }}" class="btn btn-secondary"
                   title="Agregar Folio">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($mesaFolios) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron folios.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Libro Digital</th>
                            <th>Master Materia</th>
                            <th>Mesa</th>
                            <th>Turno</th>
                            <th>Folio</th>
                            <th>Presidente</th>
                            <th>Vocal 1</th>
                            <th>Vocal 2</th>
                            <th>Aprobados</th>
                            <th>Desaprobados</th>
                            <th>Ausentes</th>
                            <th>Coordinador</th>


                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mesaFolios as $mesaFolio)
                            <tr>
                                <td class="align-middle">{{ $mesaFolio->fecha }}</td>
                                <td class="align-middle">{{ $mesaFolio->LibroDigital->romanos }}</td>
                                <td class="align-middle">{{ optional($mesaFolio->MasterMateria)->name }}</td>
                                <td class="align-middle">{{ optional($mesaFolio->Mesa)->fecha }}</td>
                                <td class="align-middle">{{ $mesaFolio->turno }}</td>
                                <td class="align-middle">{{ $mesaFolio->folio }}</td>
                                <td class="align-middle">{{ optional($mesaFolio->presidente)->getApellidoNombre() }}</td>
                                <td class="align-middle">{{ optional($mesaFolio->vocal1)->getApellidoNombre() }}</td>
                                <td class="align-middle">{{ optional($mesaFolio->vocal2)->getApellidoNombre() }}</td>
                                <td class="align-middle">{{ $mesaFolio->aprobados }}</td>
                                <td class="align-middle">{{ $mesaFolio->desaprobados }}</td>
                                <td class="align-middle">{{ $mesaFolio->ausentes }}</td>
                                <td class="align-middle">{{ optional($mesaFolio->coordinador_id)->getApellidoNombre() }}</td>

                                <td class="text-end">
                                    <form method="POST"
                                          action="{!! route('mesa_folios.mesa_folio.destroy', $mesaFolio->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('mesa_folios.mesa_folio.show', $mesaFolio->id ) }}"
                                               class="btn btn-info" title="Ver Folio">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('mesa_folios.mesa_folio.edit', $mesaFolio->id ) }}"
                                               class="btn btn-primary" title="Editar Folio">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Mesa Folio"
                                                    onclick="return confirm('Asegurate de confirmar la eliminación de este Folio.')">
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

                {!! $mesaFolios->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
