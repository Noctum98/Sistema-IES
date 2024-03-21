@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Condición
                Materia: {{ isset($condicionMateria->nombre) ? $condicionMateria->nombre : '' }}</h4>
            <div>
                <form method="POST"
                      action="{!! route('condicion_materias.condicion_materia.destroy', $condicionMateria->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('condicion_materias.condicion_materia.edit', $condicionMateria->id ) }}"
                       class="btn btn-primary" title="Editar Condición Materia">
                        <span class="fa fa-pen" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Borrar Condición Materia"
                            onclick="return confirm(&quot;Aceptar para borrar Condición Materia.&quot;)">
                        <span class="fa fa-trash" aria-hidden="true"></span> Borrar
                    </button>

                    <a href="{{ route('condicion_materias.condicion_materia.index') }}" class="btn btn-primary"
                       title="Listar Condición Materia">
                        <span class="fa fa-table" aria-hidden="true"></span> Listar
                    </a>

                    <a href="{{ route('condicion_materias.condicion_materia.create') }}" class="btn btn-secondary"
                       title="Crear nueva Condición Materia">
                        <span class="fa fa-plus" aria-hidden="true"></span> Crear
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionMateria->nombre }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Identificador</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionMateria->identificador }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Habilitado</dt>
                <dd class="col-lg-10 col-xl-9">
                    @if($condicionMateria->habilitado)
                        <i class="fa fa-check text-success"></i>
                    @else
                        <i class="fa fa-times text-danger"></i>
                    @endif
                </dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($condicionMateria->operador)->getApellidoNombre() }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Borrado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionMateria->deleted_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionMateria->created_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionMateria->updated_at }}</dd>

            </dl>

        </div>
    </div>

@endsection
