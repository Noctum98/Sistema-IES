@extends('layouts.app-prueba')
<x-asset_fa_652/>
@section('content')

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">{{ isset($correlatividadAgrupada->Name) ? $correlatividadAgrupada->Name : 'Correlatividad Agrupada' }}</h4>
            <div>
                <form method="POST"
                      action="{!! route('correlatividad_agrupadas.correlatividad_agrupada.destroy', $correlatividadAgrupada->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}

                    <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.edit', $correlatividadAgrupada->id ) }}"
                       class="btn btn-primary" title="Editar Correlatividad Agrupada">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                    </a>
                    <a href="{{ route('agrupada_materias.agrupada_materia.edit_group', $correlatividadAgrupada->id ) }}"
                       class="btn btn-info" title="Agregar Materia Agrupada">
                        <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Agregar Materia
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Correlatividad Agrupada"
                            onclick="return confirm('¿Esta seguro de borrar Correlatividad Agrupada.?')">
                        <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Borrar
                    </button>

                    <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.index') }}"
                       class="btn btn-primary" title="Listar Correlatividades Agrupadas">
                        <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                    </a>

                    <a href="{{ route('correlatividad_agrupadas.correlatividad_agrupada.create') }}"
                       class="btn btn-secondary" title="Agregar Correlatividad Agrupada">
                        <span class="fa-solid fa-plus" aria-hidden="true"></span> Agregar
                    </a>

                </form>
            </div>
        </div>

        <div class="card-body">

            <dl class="row">
                <dt class="text-lg-end col-lg-2 col-xl-3">Nombre</dt>
                <dd class="col-lg-10 col-xl-9">{{ $correlatividadAgrupada->name }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Descripción</dt>
                <dd class="col-lg-10 col-xl-9">{{ $correlatividadAgrupada->description }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Identificador</dt>
                <dd class="col-lg-10 col-xl-9">{{ $correlatividadAgrupada->identifier }}</dd>
                <dt class="text-lg-end col-lg-2 col-xl-3">Resolución N°:</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($correlatividadAgrupada->Resoluciones)->name }}</dd>
                @if($correlatividadAgrupada->disabled)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Deshabilitada</dt>
                    <dd class="col-lg-10 col-xl-9">{{ ($correlatividadAgrupada->disabled) ? 'Si' : 'No' }}</dd>
                @endif
                <dt class="text-lg-end col-lg-2 col-xl-3">Creada</dt>
                <dd class="col-lg-10 col-xl-9">{{ $correlatividadAgrupada->created_at }}</dd>
                @if($correlatividadAgrupada->created_at != $correlatividadAgrupada->updated_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Actualizada</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $correlatividadAgrupada->updated_at }}</dd>
                @endif
                @if($correlatividadAgrupada->deleted_at)
                    <dt class="text-lg-end col-lg-2 col-xl-3">Eliminada</dt>
                    <dd class="col-lg-10 col-xl-9">{{ $correlatividadAgrupada->deleted_at }}</dd>
                @endif
                <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                <dd class="col-lg-10 col-xl-9">{{ optional($correlatividadAgrupada->user)->getApellidoNombre() }}</dd>

            </dl>
            <hr/>
            <div class="card-body ml-5">
                <h4>Materias Agrupadas</h4>
                <dl class="row ml-5">
                    @foreach($correlatividadAgrupada->agrupadaMaterias as $agrupadaMateria)
                        <hr/>
                        <dt class="text-lg-end col-lg-2 col-xl-3">Materia</dt>
                        <dd class="col-lg-10 col-xl-9">{{ optional($agrupadaMateria->MasterMateria)->name }}</dd>
                        <dt class="text-lg-end col-lg-2 col-xl-3">Creada</dt>
                        <dd class="col-lg-10 col-xl-9">{{ $agrupadaMateria->created_at }}</dd>
                        @if($agrupadaMateria->deleted_at)
                            <dt class="text-lg-end col-lg-2 col-xl-3">Eliminada</dt>
                            <dd class="col-lg-10 col-xl-9">{{ $agrupadaMateria->deleted_at }}</dd>
                        @endif
                        @if($agrupadaMateria->disabled)
                            <dt class="text-lg-end col-lg-2 col-xl-3">Deshabilitada</dt>
                            <dd class="col-lg-10 col-xl-9">{{ ($agrupadaMateria->disabled) ? 'Si' : 'No' }}</dd>
                        @endif
                        @if($agrupadaMateria->created_at != $agrupadaMateria->updated_at)
                            <dt class="text-lg-end col-lg-2 col-xl-3">Actualizada</dt>
                            <dd class="col-lg-10 col-xl-9">{{ $agrupadaMateria->updated_at }}</dd>
                        @endif



                        <dt class="text-lg-end col-lg-2 col-xl-3">Operador</dt>
                        <dd class="col-lg-10 col-xl-9">{{ optional($agrupadaMateria->user)->getApellidoNombre() }}</dd>

                    @endforeach
                </dl>


            </div>
        </div>

@endsection
