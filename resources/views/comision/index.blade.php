@extends('layouts.app-prueba')
@section('content')
<div class="container p-3">
    <a href="{{route('materia.admin',$carrera->id)}}">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>
    <h2 class="h1 text-info">
        Comisiones de {{ $carrera->nombre }}
    </h2>
    <hr>
    @if(@session('comision_eliminada'))
    <div class="alert alert-warning">
        {{ @session('comision_eliminada') }}
    </div>
    @endif
    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Año</th>
                <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($comisiones as $comision)
            <tr style="cursor:pointer;">
                <td>{{ $comision->nombre }}</td>
                <td>
                    {{ $comision->año }}
                </td>
                <td>
                    <a href="{{ route('comisiones.show',$comision->id) }}" class="btn btn-sm btn-secondary">Ver</a>
                    <a class="btn btn-warning " data-bs-toggle="modal" id="editButton" data-bs-target="#editModal"
                       data-loader="{{$comision->id}}" data-attr="{{ route('comision.edit', $comision->id) }}">
                        <i class="fas fa-edit text-gray-300"></i>
                        <i class="fa fa-spinner fa-spin" style="display: none" id="loader{{$comision->id}}"></i>
                    </a>
                    <form action="{{route('comisiones.destroy',$comision->id)}}" method="POST" class="d-inline">
                        {{ method_field('DELETE') }}
                        <input type="submit" value="Eliminar" class="btn btn-sm btn-danger">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{url()->previous()}}">
        <button class="btn btn-outline-info mb-2"><i class="fas fa-angle-left"></i> Volver</button>
    </a>
</div>
@include('comision.modals.editar_comision')
@endsection
@section('scripts')
    <script>

        $(document).on('click', '#editButton', function(event) {
            console.log('nada');
            event.preventDefault();
            let href = $(this).attr('data-attr');
            let referencia = $(this).attr('data-loader');
            const $laoder = $('#loader'+referencia);

            $.ajax({
                url: href,
                beforeSend: function() {
                    $laoder.show();
                },
                // return the result
                success: function(result) {
                    $('#editModal').modal("show");
                    $('#editBody').html(result).show();
                },
                complete: function() {
                    $laoder.hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);

                    $laoder.hide();
                },
                timeout: 8000
            })
        });
    </script>
@endsection