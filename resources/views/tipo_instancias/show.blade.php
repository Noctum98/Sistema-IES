@extends('layouts.app')

@section('content')

<div class="card text-bg-theme">

     <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h4 class="m-0">{{ isset($tipoInstancia->name) ? $tipoInstancia->name : 'Tipo Instancia' }}</h4>
        <div>
            <form method="POST" action="{!! route('tipo_instancias.tipo_instancia.destroy', $tipoInstancia->id) !!}" accept-charset="UTF-8">
                <input name="_method" value="DELETE" type="hidden">
                {{ csrf_field() }}

                <a href="{{ route('tipo_instancias.tipo_instancia.edit', $tipoInstancia->id ) }}" class="btn btn-primary" title="Edit Tipo Instancia">
                    <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                </a>

                <button type="submit" class="btn btn-danger" title="Delete Tipo Instancia" onclick="return confirm(&quot;Click Ok to delete Tipo Instancia.?&quot;)">
                    <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                </button>

                <a href="{{ route('tipo_instancias.tipo_instancia.index') }}" class="btn btn-primary" title="Show All Tipo Instancia">
                    <span class="fa-solid fa-table-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('tipo_instancias.tipo_instancia.create') }}" class="btn btn-secondary" title="Create New Tipo Instancia">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>

            </form>
        </div>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="text-lg-end col-lg-2 col-xl-3">Name</dt>
            <dd class="col-lg-10 col-xl-9">{{ $tipoInstancia->name }}</dd>
            <dt class="text-lg-end col-lg-2 col-xl-3">Identifier</dt>
            <dd class="col-lg-10 col-xl-9">{{ $tipoInstancia->identifier }}</dd>

        </dl>

    </div>
</div>

@endsection