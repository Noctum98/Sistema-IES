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
            <h4 class="m-0">Libro Digital</h4>
            <div>
                <a href="{{ route('libros_digitales.libro_digital.create') }}" class="btn btn-secondary"
                   title="Agregar Libro Digital">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                </a>
            </div>
        </div>

        @if(count($librosDigitales) == 0)
            <div class="card-body text-center">
                <h4>No se encontraron libros digitales.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Número</th>
                            <th>N° Romanos</th>
                            <th>Resolución</th>
                            <th>Libro físico</th>
                            <th>Fecha Inicio</th>
                            <th>Sede</th>
                            <th>Observaciones</th>
                            <th>User</th>
                            <th>Última Actualización</th>
                            <th class="text-center align-middle">
                                <i class="fa fa-trash"></i>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($librosDigitales as $libroDigital)
                            <tr>
                                <td class="align-middle">{{ $libroDigital->number }}</td>
                                <td class="align-middle">{{ $libroDigital->romanos }}</td>
                                <td class="align-middle">{{ optional($libroDigital->resoluciones)->name }}</td>
                                <td class="align-middle">{{ optional($libroDigital->libroPapel)->name }}</td>
                                <td>{{ $libroDigital->fecha_inicio ? date_format(new DateTime( $libroDigital->fecha_inicio ), 'd-m-Y') : '' }}</td>
                                <td class="align-middle">{{ optional($libroDigital->sede)->nombre }}</td>
                                <td class="align-middle">{!! Str::words("$libroDigital->observaciones", 5,' ...') !!}</td>
                                <td class="align-middle">{{ optional($libroDigital->user)->getApellidoNombre() }}</td>
                                <td class="align-middle">{{ $libroDigital->updated_at }}</td>
                                <td class="text-center align-middle">
                                    @if($libroDigital->deleted_at)
                                      <i class="text-danger"> Si </i>
                                    @else
                                        <i class="text-success"> No </i>
                                    @endif
                                </td>


                                <td class="text-end">
                                    <form method="POST"
                                          action="{!! route('libros_digitales.libro_digital.destroy', $libroDigital->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('libros_digitales.libro_digital.show', $libroDigital->id ) }}"
                                               class="btn btn-info" title="Ver Libro Digital">
                                                <span class="fa-solid fa-arrow-up-right-from-square"
                                                      aria-hidden="true"></span> Ver
                                            </a>
                                            <a href="{{ route('libros_digitales.libro_digital.edit', $libroDigital->id ) }}"
                                               class="btn btn-primary" title="Editar Libro Digital">
                                                <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                                Editar
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Eliminar Libro Digital"
                                                    onclick="return confirm('Aceptar para eliminar libro digital.')">
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

                {!! $librosDigitales->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection

