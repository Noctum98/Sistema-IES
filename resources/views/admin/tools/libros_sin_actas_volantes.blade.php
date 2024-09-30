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
            <h4 class="m-0">Libros sin cargar</h4>
        </div>

        @if(count($libros) === 0)
            <div class="card-body text-center">
                <h4>No se encontraron libros sin actas volantes.</h4>
            </div>
        @else
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mesa</th>
                            <th>Carrera - Sede</th>
                            <th>Llamado</th>
                            <th>Número</th>
                            <th>Folio</th>
                            <th>Orden</th>
                            <th>Ult. acceso</th>
                            <th class="text-center"><i class="fa fa-cogs"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($libros as $libro)
                            <tr>
                                <td class="align-middle">{{ $libro->id }}</td>
                                <td class="align-middle">
                                    <small style="font-size:0.75em">
                                        {{$libro->mesa->id}}
                                    </small> -
                                    {{ $libro->mesa->fecha}}
                                    - {{$libro->mesa->materia->nombre}}</td>
                                <td class="align-middle">{{ $libro->mesa->materia->carrera->nombre}}
                                    - {{$libro->mesa->materia->carrera->sede->nombre}}</td>
                                <td class="align-middle">{{ $libro->llamado}}</td>
                                <td class="align-middle">{{ $libro->numero}}</td>
                                <td class="align-middle">{{ $libro->folio}}</td>
                                <td class="align-middle">{{ $libro->orden}}</td>
                                <td class="align-middle">{{ $libro->updated_at}}</td>
                                <td class="text-center">
{{--                                    <a href="{{route('libros_digitales.libro_digital.cargar_libro',--}}
{{--                                                ['libro' => $libro->id])}}"--}}
{{--                                       class="btn btn-sm btn-primary"--}}
{{--                                    >--}}
{{--                                        Cargar actas volantes--}}
{{--                                    </a>--}}
                                    <a href="{{route('libros_digitales.libro_digital.cargar_libro_inscripciones',
                                        ['libro' => $libro->id])}}"
                                       class="btn btn-sm btn-primary"
                                    >
                                        Cargar actas volantes
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                {!! $libros->links('pagination') !!}
            </div>

        @endif

    </div>
@endsection
