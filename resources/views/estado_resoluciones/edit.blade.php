@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($estadoResoluciones->name) ? $estadoResoluciones->name : 'Estado Resoluciones' }}</h4>
            <div>
                <a href="{{ route('estado_resoluciones.estado_resoluciones.index') }}" class="btn btn-primary"
                   title="Listar Estados Resoluciones">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                </a>

                <a href="{{ route('estado_resoluciones.estado_resoluciones.create') }}" class="btn btn-secondary"
                   title="Agregar nuevo Estado Resoluciones">
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
                  action="{{ route('estado_resoluciones.estado_resoluciones.update', $estadoResoluciones->id) }}"
                  id="edit_estado_resoluciones_form" name="edit_estado_resoluciones_form" accept-charset="UTF-8">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('estado_resoluciones.form', [
                                            'estadoResoluciones' => $estadoResoluciones,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Actualizar">
                </div>
            </form>

        </div>
    </div>

@endsection
