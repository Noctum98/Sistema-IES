@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($correlatividadAgrupada->Name) ? $correlatividadAgrupada->Name : 'Correlatividad Agrupada' }}</h4>
            <div>
                <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.index') }}" class="btn btn-primary"
                   title="Listar Correlatividades Agrupadas">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listar
                </a>

                <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.create') }}"
                   class="btn btn-secondary" title="Agregar Correlatividad Agrupada">
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
                  action="{{ route('correlatividad_agrupadas.correlatividad_agrupada.update', $correlatividadAgrupada->id) }}"
                  id="edit_correlatividad_agrupada_form" name="edit_correlatividad_agrupada_form"
                  accept-charset="UTF-8">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('correlatividad_agrupadas.form', [
                                            'correlatividadAgrupada' => $correlatividadAgrupada,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Actualizar">
                </div>
            </form>

        </div>
    </div>

@endsection
