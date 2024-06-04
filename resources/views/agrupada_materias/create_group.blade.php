@extends('layouts.app-prueba')
<x-asset_fa_652/>
@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Agregar Materia Agrupada</h4>
            <div>
                <a href="{{ route('agrupada_materias.agrupada_materia.index') }}" class="btn btn-primary"
                   title="Listar materias agrupadas">
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
                  action="{{ route('agrupada_materias.agrupada_materia.store_group') }}" accept-charset="UTF-8"
                  id="create_agrupada_materia_form_group" name="create_agrupada_materia_form_group">
                {{ csrf_field() }}
                @include ('agrupada_materias.form_group', [
                                            'agrupadaMateria' => null,
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
            $('#master_materia_id').select2({
                width: "100%",
                theme: "bootstrap",
                clear: true,
                placeholder: "Seleccione materia"
            });
        });
    </script>
@endsection
