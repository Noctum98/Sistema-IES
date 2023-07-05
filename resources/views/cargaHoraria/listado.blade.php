@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h4 class="text-dark">
            Administrar Carga Horaria Personal
        </h4>
        <a href="{{ route('personal.admin') }}" class="btn btn-success">
            Agregar personal
        </a>
        <div class="d-flex justify-content-center" style="font-size: 0.8em">
            {{ $personal->links() }}
        </div>
        <div class="col-md-8">
            <table class="table mt-4">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Sede</th>
                    <th scope="col">Cargo</th>
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($personal as $persona)
                    <tr>
                        <td>{{ $persona->nombre.' '.$persona->apellido }}</td>
                        <td>{{ optional($persona->sede)->nombre }}</td>
                        <td>{{ ucwords($persona->cargo) }}</td>
                        <td>

                            <a href="{{ route('cargaHoraria.ver',['persona'=>$persona->id]) }}" class="btn-sm btn-warning">
                                Ver Carga horaria
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center" style="font-size: 0.8em">
            {{ $personal->links() }}
        </div>

    </div>
@endsection
