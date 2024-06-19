@extends('layouts.app-prueba')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

{{--        <div class="card-header d-flex justify-content-between align-items-center p-3">--}}
{{--            <h4 class="m-0">Libros</h4>--}}
{{--            <div>--}}
{{--                <a href="{{ route('libros.libros.create') }}" class="btn btn-secondary" title="Create New Libros">--}}
{{--                    <span class="fa-solid fa-plus" aria-hidden="true"></span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}

        @if(count($librosObjects) == 0)
            <div class="card-body text-center">
                <h4>No Libros Available.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Folio</th>
                            <th>Orden</th>
                            <th>Llamado</th>
                            <th>Mesa</th>


                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($librosObjects as $libros)
                        <tr>
                            <td class="align-middle">{{ $libros->numero }}</td>
                            <td class="align-middle">{{ $libros->folio }}</td>
                            <td class="align-middle">{{ $libros->orden }}</td>
                            <td class="align-middle">{{ $libros->llamado }}</td>
                            <td class="align-middle">{{date_format(new DateTime($libros->mesa->fecha),'d-m-Y')}}</td>

                            <td class="text-end">

{{--                                <form method="POST" action="{!! route('libros.libros.destroy', $libros->id) !!}" accept-charset="UTF-8">--}}
{{--                                <input name="_method" value="DELETE" type="hidden">--}}
{{--                                {{ csrf_field() }}--}}

{{--                                    <div class="btn-group btn-group-sm" role="group">--}}
{{--                                        <a href="{{ route('libros.libros.show', $libros->id ) }}" class="btn btn-info" title="Show Libros">--}}
{{--                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>--}}
{{--                                        </a>--}}
{{--                                        <a href="{{ route('libros.libros.edit', $libros->id ) }}" class="btn btn-primary" title="Edit Libros">--}}
{{--                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>--}}
{{--                                        </a>--}}

{{--                                        <button type="submit" class="btn btn-danger" title="Delete Libros" onclick="return confirm(&quot;Click Ok to delete Libros.&quot;)">--}}
{{--                                            <span class="fa-regular fa-trash-can" aria-hidden="true"></span>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}

{{--                                </form>--}}

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            {!! $librosObjects->links('pagination') !!}
        </div>

        @endif

    </div>
@endsection
