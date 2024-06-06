@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Agregar Biblioteca</h4>
            <h6>Último orden asignado: {{$max??0}}</h6>
            <div>
                <a href="{{ route('admin-libraries.library.index') }}" class="btn btn-primary" title="Listado">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                </a>
            </div>
        </div>


        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" class="needs-validation" novalidate action="{{ route('admin-libraries.library.store') }}"
                  accept-charset="UTF-8" id="create_library_form" name="create_library_form">
                {{ csrf_field() }}
                @include ('admin.library.form', [
                                            'library' => null,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Agregar">
                </div>

            </form>

        </div>
    </div>

@endsection
