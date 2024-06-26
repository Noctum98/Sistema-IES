@extends('layouts.app-prueba')
<x-asset_fa_652/>
@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Agregar Correlatividad Agrupada</h4>
            <div>
                <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.index') }}" class="btn btn-primary"
                   title="Listar Correlatividades Agrupadas">
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
                  action="{{ route('correlatividad_agrupadas.correlatividad_agrupada.store') }}" accept-charset="UTF-8"
                  id="create_correlatividad_agrupada_form" name="create_correlatividad_agrupada_form">
                {{ csrf_field() }}
                @include ('correlatividad_agrupadas.form', [
                                            'correlatividadAgrupada' => null,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Agregar">
                </div>

            </form>

        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#resoluciones_id').select2({
                width: "100%",
                theme: "classic",
                clear: true,
                placeholder: "Seleccione resolución"
            });
        });
    </script>
@endsection
