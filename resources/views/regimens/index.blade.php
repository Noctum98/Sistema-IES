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
            <h4 class="m-0">Regimens</h4>
            <div>
                <a href="{{ route('regimens.regimen.create') }}" class="btn btn-secondary" title="Crear Régimen">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($regimens) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron Regímenes Disponibles.</h4>
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
                        @foreach($regimens as $regimen)
                            <tr>
                                <td class="align-middle">{{ $regimen->name }}</td>
                                <td class="align-middle">{{ $regimen->identifier }}</td>

                                <td class="text-end">

                                    <form method="POST" action="{!! route('regimens.regimen.destroy', $regimen->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('regimens.regimen.show', $regimen->id ) }}"
                                               class="btn btn-info" title="Ver Régimen">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span>
                                            </a>
                                            <a href="{{ route('regimens.regimen.edit', $regimen->id ) }}"
                                               class="btn btn-primary" title="Editar Régimen">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Borrar Régimen"
                                                    onclick="return confirm(&quot;Click Ok para borrar Régimen.&quot;)">
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

                {!! $regimens->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
