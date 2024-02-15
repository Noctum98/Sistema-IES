@extends('layouts.app-prueba')
@section('content')
<div class="container">
    @include('layouts.cssCard')
    <div class="container-fluid">
        <div class="card">
            <div class="row p-1">
                <div>
                </div>

                <div class="card-header border-radius col-sm-12 flex-column">
                    <div class="text-center">
                        <div class="col-sm-7 mx-auto">

                            <h5 class="card-title">
                                <small>Configuración de</small> Calendario
                            </h5>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createFecha">Agregar fecha <i class="fas fa-plus"></i></button>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha (M-D)</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($fechas->count() > 0)
                                @foreach($fechas as $fecha)
                                <tr>
                                    <th scope="row">{{ $fecha->fecha }}</th>
                                    <td>{{ mb_strtoupper($fecha->tipo) }}</td>
                                    <td title="{{ $fecha->descripcion }}">{{ Str::limit($fecha->descripcion, $limit = 50, $end = '...') }}</td>
                                    <td>
                                        <div class="row">
                                            <form action="{{ route('calendario.destroy',$fecha->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esto?');" class="col-md-2 m-1">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form> <button class="col-md-2 btn btn-sm btn-warning m-1" data-bs-toggle="modal" data-bs-target="#editFecha{{ $fecha->id }}"><i class="fas fa-edit text-gray-300"></i></button>
                                        </div>
                                        @include('calendario.modals.edit',['calendario'=>$fecha])
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4">
                                        <p>No existe ninguna fecha.</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('calendario.modals.create')
    @endsection