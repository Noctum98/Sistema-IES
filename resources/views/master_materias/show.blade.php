@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($masterMateria->name) ? $masterMateria->name : 'Master Materia' }}</h4>
            <div>
                <form method="POST" action="{!! route('master_materias.master_materia.destroy', $masterMateria->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('master_materias.master_materia.edit', $masterMateria->id ) }}"
                       class="btn btn-primary" title="Editar Master Materia">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Borrar Master Materia"
                            onclick="return confirm(&quot;Click Ok para borrar Master Materia.?&quot;)">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                    </button>

                    <a href="{{ route('master_materias.master_materia.index') }}" class="btn btn-primary"
                       title="Listar Master Materia">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('master_materias.master_materia.create') }}" class="btn btn-secondary"
                       title="Crear Master Materia">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span>
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $masterMateria->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Años</dt>
                <dd class="col-lg-10 col-xl-9">{{ $masterMateria->year }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Etapa Campo</dt>
                <dd class="col-lg-10 col-xl-9">{{ ($masterMateria->field_stage) ? 'Si' : 'No' }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Cierre Diferido</dt>
                <dd class="col-lg-10 col-xl-9">{{ ($masterMateria->delayed_closing) ? 'Si' : 'No' }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Resolución</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($masterMateria->Resolucione)->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Régimen</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($masterMateria->Regimen)->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Borrado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $masterMateria->deleted_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $masterMateria->created_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $masterMateria->updated_at }}</dd>

            </dl>

        </div>
    </div>

@endsection
