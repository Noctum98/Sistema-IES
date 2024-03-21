@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Condición
                Materia: {{ !empty($condicionMateria->nombre) ? $condicionMateria->nombre : '' }}</h4>
            <div>
                <a href="{{ route('condicion_materias.condicion_materia.index') }}" class="btn btn-primary"
                   title="Listar Condición Materia">
                    <span class="fa fa-table" aria-hidden="true"></span> Listar
                </a>

                <a href="{{ route('condicion_materias.condicion_materia.create') }}" class="btn btn-secondary"
                   title="Crear Nueva Condición Materia">
                    <span class="fa fa-plus" aria-hidden="true"></span> Crear
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
                  action="{{ route('condicion_materias.condicion_materia.update', $condicionMateria->id) }}"
                  id="edit_condicion_materia_form" name="edit_condicion_materia_form" accept-charset="UTF-8">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('condicion_materias.form', [
                                            'condicionMateria' => $condicionMateria,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Actualizar">
                </div>
            </form>

        </div>
    </div>

@endsection
