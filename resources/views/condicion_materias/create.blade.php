@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Crear Nueva Condición Materia</h4>
            <div>
                <a href="{{ route('condicion_materias.condicion_materia.index') }}" class="btn btn-primary"
                   title="Listar Condición Materia">
                    <span class="fa fa-table" aria-hidden="true"></span> Listar
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
                  action="{{ route('condicion_materias.condicion_materia.store') }}" accept-charset="UTF-8"
                  id="create_condicion_materia_form" name="create_condicion_materia_form">
                {{ csrf_field() }}
                @include ('condicion_materias.form', [
                                            'condicionMateria' => null,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Guardar">
                </div>

            </form>

        </div>
    </div>

@endsection
