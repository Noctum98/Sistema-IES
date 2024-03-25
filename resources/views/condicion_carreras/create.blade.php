@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

         <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Crear Nueva Condición Carrera</h4>
            <div>
                <a href="{{ route('condicion_carreras.condicion_carrera.index') }}" class="btn btn-primary" title="Ver todas las condiciones de carrera">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Ver condiciones carrera
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

            <form method="POST" class="needs-validation" novalidate action="{{ route('condicion_carreras.condicion_carrera.store') }}" accept-charset="UTF-8" id="create_condicion_carrera_form" name="create_condicion_carrera_form" >
            {{ csrf_field() }}
            @include ('condicion_carreras.form', [
                                        'condicionCarrera' => null,
                                      ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Agregar">
                </div>

            </form>

        </div>
    </div>

@endsection


