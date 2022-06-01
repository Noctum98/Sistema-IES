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
                            <th scope="col">Descripción</th>
                            <th scope="col">Nombre</th>
                            <th scope="col" class="text-center"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($tipoCalificaciones as $tc)
                            <tr>
                                <td>{{$tc->descripcion}}</td>
                                <td>{{$tc->nombre}}</td>
                                <td class="align-content-between">

                                    <a class="btn btn-warning" data-bs-toggle="modal" id="editButton" data-target="#editModal"
                                       data-loader="{{$tc->id}}" data-attr="{{ route('tipoCalificaciones.edit', $tc->id) }}">
                                        <i class="fas fa-edit text-gray-300"></i>
                                        <i class="fa fa-spinner fa-spin" style="display: none" id="loader{{$tc->id}}"></i>
                                    </a>

                                    <form method="POST" class="d-inline"
                                          action="{{route('tipoCalificaciones.destroy', ['tipoCalificacione' => $tc->id])}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"
                                                onclick="return confirm('Se borrará el registro. ¿Confirma?.')"
                                                type="submit"> Borrar
                                        </button>
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

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="editBody">
                        <div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>


        $(document).on('click', '#editButton', function(event) {
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
