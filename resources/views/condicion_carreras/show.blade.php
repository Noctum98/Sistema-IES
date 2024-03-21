@extends('layouts.app-prueba')

@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($condicionCarrera->nombre) ? $condicionCarrera->nombre : 'Condición Carrera' }}</h4>
            <div>
                <form method="POST"
                      action="{!! route('condicion_carreras.condicion_carrera.destroy', $condicionCarrera->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('condicion_carreras.condicion_carrera.edit', $condicionCarrera->id ) }}"
                       class="btn btn-primary" title="Editar Condición Carrera">
                        <span class="fa fa-pen" aria-hidden="true"></span> Editar
                    </a>

                    <button type="submit" class="btn btn-danger" title="Borrar Condición Carrera"
                            onclick="return confirm(&quot;Aceptar para borrar Condición Carrera.&quot;)">
                        <span class="fa fa-trash" aria-hidden="true"></span> Borrar
                    </button>

                    <a href="{{ route('condicion_carreras.condicion_carrera.index') }}" class="btn btn-primary"
                       title="Mostrar todas las Condiciones Carrera">
                        <span class="fa fa-table" aria-hidden="true"></span> Listado Condición Carrera
                    </a>

                    <a href="{{ route('condicion_carreras.condicion_carrera.create') }}" class="btn btn-secondary"
                       title="Crear Condición Carrera">
                        <span class="fa fa-plus" aria-hidden="true"></span> Crear
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->nombre }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Identificador</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->identificador }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Habilitado</dt>
                <dd class="col-lg-10 col-xl-9">
                    @if($condicionCarrera->habilitado)
                        <i class="fa fa-check text-success"></i>
                    @else
                        <i class="fa fa-times text-danger"></i>
                    @endif
                </dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($condicionCarrera->operador)->getApellidoNombre() }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Borrado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->deleted_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Creado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->created_at }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado</dt>
                <dd class="col-lg-10 col-xl-9">{{ $condicionCarrera->updated_at }}</dd>
            </dl>
        </div>
    </div>
@endsection
