@extends('layouts.app-prueba')
<x-asset_fa_652/>
@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ !empty($title) ? $title : 'Agrupada Materia' }}</h4>
            <div>
                <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.index') }}" class="btn btn-primary"
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
                  action="{{ route('agrupada_materias.agrupada_materia.update_group', $correlatividadAgrupada->id) }}"
                  id="edit_agrupada_materia_form" name="edit_agrupada_materia_form" accept-charset="UTF-8">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('agrupada_materias.form_group', [
                                            'agrupadaMateria' => $MasterMaterias,
                                          ])

                <div class="col-lg-10 col-xl-9 offset-lg-2 offset-xl-3">
                    <input class="btn btn-primary" type="submit" value="Actualizar">
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
