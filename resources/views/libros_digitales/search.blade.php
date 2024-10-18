@extends('layouts.app-prueba')

@section('content')
    <x-style_libro_digital/>

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Libros Digitales</h4>
        </div>
        <div class="d-flex col-sm-12 justify-content-center align-items-center p-3">
            <nav aria-label="navigation text-center">
                <ul class="pagination">
                    @foreach($sedes as $sede)
                        <li class="page-item rounded {{ $sede === $sede_id ? 'active' : '' }} px-2">
                            <a class="page-link"
                               href="{{ route('libros_digitales.libro_digital.index_sede', ['sede_id' => $sede]) }}">
                                {{ $sede }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>


@endsection

