@extends('layouts.app-prueba')
@section('content')
    <div class="container-fluid">
        <h2 class="text-info">
            Administrar carreras
        </h2>
        <hr>
        @if(Auth::user()->hasRole('admin'))
            <a href="{{ route('carrera.crear') }}" class="btn btn-success">
                Crear carrera
            </a>
        @endif
        <div class="table-responsive">
            <table class="table mt-4">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Turno</th>
                    <th>Resolución</th>
                    @if(Session::has('admin'))
                        <th scope="col">Estado</th>
                    @endif
                    <th scope="col">Ubicación</th>
                    <th scope="col">Tipo</th>
                    {{-- Para el nuevo ram --}}
                    @if(Session::has('admin'))
                        <th scope="col">Condición</th>
                    @endif
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                </tr>
                </thead>
                <tbody>

                @foreach($carreras as $carrera)
                    <tr style="cursor:pointer;">
                        <td><b>{{ $carrera->id }}</b></td>
                        <td>{{ $carrera->nombre }}</td>
                        <td>{{ ucwords($carrera->turno) }}</td>
                        <td>{{ $carrera->getResolucion->resolution?? $carrera->resolucion }}</td>
                        @if(Auth::user()->hasRole('admin'))
                            <td>
                                @if($carrera->estado == 1)
                                    <span class="text-danger font-weight-bold">En cierre</span>
                                @elseif($carrera->estado == 0)
                                    <span class="text-success font-weight-bold">En curso</span>
                                @elseif($carrera->estado == 2)
                                    <span class="text-primary font-weight-bold">En Apertura</span>
                                @endif
                            </td>
                        @endif
                        <td>{{ $carrera->sede->nombre }}</td>
                        <td>
                            @include('componentes.tipoCarrera.tradicionalToDisciplinar', ['tipo' => $carrera->tipo])
                        </td>
                        {{--                         Para el nuevo ram--}}
                        @if(Session::has('admin'))
                            <td>{{ ucfirst(optional($carrera->condicionCarrera)->nombre) }}</td>
                        @endif
                        <td>
                            @if(Session::has('admin') || Session::has('regente'))
                                <a href="{{ route('carrera.editar',['id'=>$carrera->id]) }}"
                                   class="mr-2 col-md-6 btn btn-sm btn-warning">
                                    Editar
                                </a>
                            @endif
                            <a href="{{ route('materia.admin',['carrera_id'=>$carrera->id]) }}"
                               class="mt-2 col-md-6 btn btn-sm btn-primary">
                                Ver plan de estudios
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </div>
@endsection
