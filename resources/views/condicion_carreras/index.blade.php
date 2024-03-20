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
            <h4 class="m-0">Condicion Carreras</h4>
            <div>
                <a href="{{ route('condicion_carreras.condicion_carrera.create') }}" class="btn btn-secondary" title="Create New Condicion Carrera">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        @if(count($condicionCarreras) == 0)
            <div class="card-body text-center">
                <h4>No Condicion Carreras Available.</h4>
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
                            <td class="align-middle">{{ ($condicionCarrera->habilitado) ? 'Yes' : 'No' }}</td>
                            <td class="align-middle">{{ optional($condicionCarrera->User)->username }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('condicion_carreras.condicion_carrera.destroy', $condicionCarrera->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('condicion_carreras.condicion_carrera.show', $condicionCarrera->id ) }}" class="btn btn-info" title="Show Condicion Carrera">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('condicion_carreras.condicion_carrera.edit', $condicionCarrera->id ) }}" class="btn btn-primary" title="Edit Condicion Carrera">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Condicion Carrera" onclick="return confirm(&quot;Click Ok to delete Condicion Carrera.&quot;)">
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

            {!! $condicionCarreras->links('pagination') !!}
        </div>

        @endif

    </div>
@endsection
