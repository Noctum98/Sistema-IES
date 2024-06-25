@extends('layouts.app')
<x-asset_fa_652/>
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('js/editor_web/styles/simditor.css')}}"/>
    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Agregar Libro Papel (físico)</h4>
            <div>
                <a href="{{ route('libro_papel.libro_papel.index') }}" class="btn btn-primary"
                   title="Listado Libros Papel">
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
                  action="{{ route('libro_papel.libro_papel.store') }}" accept-charset="UTF-8"
                  id="create_libro_papel_form" name="create_libro_papel_form">
                {{ csrf_field() }}
                @include ('libro_papel.form', [
                                            'libroPapel' => null,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Agregar">
                </div>

            </form>

        </div>
    </div>

@endsection
@section('scripts')
    <x-asset_simditor_js />
@endsection
