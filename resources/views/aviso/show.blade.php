@extends('layouts.app-prueba')
<link href="{{ asset('css/font-awesome/6.5.2/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v4-shims.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v5-font-face.min.css') }}" rel="stylesheet"/>
@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($title) ? $title : 'Aviso' }}</h4>
        <div>
            <form method="POST" action="{!! route('aviso.aviso.destroy', $aviso->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('aviso.aviso.edit', $aviso->id ) }}" class="btn btn-primary" title="Editar Aviso">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                </a>

{{--                <button type="submit" class="btn btn-danger" title="Borrar Aviso" onclick="return confirm(&quot;Click Ok para borrar el Aviso.?&quot;)">--}}
{{--                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span> Borrar--}}
{{--                </button>--}}

                <a href="{{ route('aviso.aviso.index') }}" class="btn btn-info" title="Ver listado avisos">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span> Listado
                </a>

                <a href="{{ route('aviso.aviso.create') }}" class="btn btn-secondary" title="Crear nuevo Aviso">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Nuevo
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Autor</dt>
            <dd class="col-lg-10 col-xl-9">{{ optional($aviso->User)->getApellidoNombre() }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Creado el</dt>
            <dd class="col-lg-10 col-xl-9">{{ $aviso->created_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Mensaje</dt>
            <dd class="col-lg-10 col-xl-9">{!! $aviso->mensaje !!}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Destinado a</dt>
            <dd class="col-lg-10 col-xl-9">{!!  $aviso->getRoles()  !!} {!! $aviso->getTodos() !!}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Actualizado el </dt>
            <dd class="col-lg-10 col-xl-9">{{ $aviso->updated_at }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Visible Desde</dt>
            <dd class="col-lg-10 col-xl-9">{{ $aviso->visible_desde }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Visible Hasta</dt>
            <dd class="col-lg-10 col-xl-9">{{ $aviso->visible_hasta }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Deshabilitado</dt>
            <dd class="col-lg-10 col-xl-9">{!! $aviso->getActivo() !!}</dd>

        </dl>

    </div>
</div>

@endsection
