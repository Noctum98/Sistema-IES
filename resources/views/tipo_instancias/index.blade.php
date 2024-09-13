@extends('layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Tipo Instancias</h4>
            <div>
                <a href="{{ route('tipo_instancias.tipo_instancia.create') }}" class="btn btn-secondary" title="Create New Tipo Instancia">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>
        
        @if(count($tipoInstancias) == 0)
            <div class="card-body text-center">
                <h4>No Tipo Instancias Available.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Identifier</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tipoInstancias as $tipoInstancia)
                        <tr>
                            <td class="align-middle">{{ $tipoInstancia->name }}</td>
                            <td class="align-middle">{{ $tipoInstancia->identifier }}</td>

                            <td class="text-end">

                                <form method="POST" action="{!! route('tipo_instancias.tipo_instancia.destroy', $tipoInstancia->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('tipo_instancias.tipo_instancia.show', $tipoInstancia->id ) }}" class="btn btn-info" title="Show Tipo Instancia">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('tipo_instancias.tipo_instancia.edit', $tipoInstancia->id ) }}" class="btn btn-primary" title="Edit Tipo Instancia">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Tipo Instancia" onclick="return confirm(&quot;Click Ok to delete Tipo Instancia.&quot;)">
                                            <span class="fa-regular fa-trash-can" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            {!! $tipoInstancias->links('pagination') !!}
        </div>
        
        @endif
    
    </div>
@endsection