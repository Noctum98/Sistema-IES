@extends('layouts.app')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($title) ? $title : 'Libro Digital' }}</h4>
            <div>
                <a href="{{ route('libros_digitales.libro_digital.index') }}" class="btn btn-primary"
                   title="Listado Libros Digitales">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                </a>

                <a href="{{ route('libros_digitales.libro_digital.create') }}" class="btn btn-secondary"
                   title="Agregar Libro Digital">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
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

            <form method="POST" class="needs-validation" novalidate
                  action="{{ route('libros_digitales.libro_digital.update', $libroDigital->id) }}"
                  id="edit_libro_digital_form" name="edit_libro_digital_form" accept-charset="UTF-8">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('libros_digitales.form', [
                                            'libroDigital' => $libroDigital,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Actualizar">
                </div>
            </form>

        </div>
    </div>

@endsection
