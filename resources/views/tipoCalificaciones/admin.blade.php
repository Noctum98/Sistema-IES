@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h2 class="h2 text-info">
            Tipos de Calificaciones
        </h2>
        <hr>
        <div class="col-md-8">
            <p>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearTipoCalificacion">
                    Crear Tipo de Calificación
                </button>
            </p>
            @include('tipoCalificaciones.modals.crear_tipo_calificacion')
            <br>
            <br>
            @if(count($tipoCalificaciones) > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">descripción</th>
                            <th scope="col">Nombre</th>
                            <th scope="col" class="text-center"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($tipoCalificaciones as $tc)
                            <tr>
                                <td>{{$tc->descripcion}}</td>
                                <td>{{$tc->nombre}}</td>
                                <td>
                                    <form method="POST" class="d-inline"
                                          action="{{route('tipoCalificaciones.destroy', ['tipoCalificacione' => $tc->id])}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"> Borrar</button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>

                </div>
        </div>
        @else
            <h4 class="text-secondary">No existen tipos de calificaciones creados</h4>
        @endif

    </div>
@endsection
