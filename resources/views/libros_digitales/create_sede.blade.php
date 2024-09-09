@extends('layouts.app')
<x-asset_fa_652/>
@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Agregar Libro Digital</h4>
            <div>
                <a href="{{ route('libros_digitales.libro_digital.index_sede') }}" class="btn btn-primary"
                   title="Listado Libros Digitales">
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

            <form method="POST" class="needs-validation" novalidate
                  action="{{ route('libros_digitales.libro_digital.store') }}" accept-charset="UTF-8"
                  id="create_libro_digital_form" name="create_libro_digital_form">
                {{ csrf_field() }}
                @include ('libros_digitales.form_sede', [
                                            'libroDigital' => null,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Agregar">
                </div>

            </form>

        </div>
    </div>

@endsection
