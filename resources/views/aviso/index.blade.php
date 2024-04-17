@extends('layouts.app-prueba')
<link href="{{ asset('css/font-awesome/6.5.2/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v4-shims.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/font-awesome/6.5.2/css/v5-font-face.min.css') }}" rel="stylesheet"/>

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {!! session('success_message') !!}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card text-bg-theme">

        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h4 class="m-0">Aviso</h4>
            <div>
                <a href="{{ route('aviso.aviso.create') }}" class="btn btn-secondary" title="Crear nuevo Aviso">
                    <span class="fa-solid fa-plus" aria-hidden="true"></span> Crear
                </a>
            </div>
        </div>

        @if(count($avisoObjects) == 0)
            <div class="card-body text-center">
                <h4>No se han creado avisos.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Autor</th>
                            <th>Roles</th>
                            <th>Fechas</th>
                            <th>Deshabilitado</th>
                            <th>Contenido</th>
                            <th class="text-center "><i class="fa-solid fa-cogs"></i> </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($avisoObjects as $aviso)
                        <tr>
                            <td class="align-middle">{{ optional($aviso->User)->getApellidoNombre() }}</td>
                            <td class="align-middle">{!!  $aviso->getRoles()  !!} {!! $aviso->getTodos() !!}</td>
                            <td class="align-middle
                                @if($aviso->isVencido())
                                    text-black-50
                                @endif
                            ">
                                <i class="fa-regular fa-calendar-check"></i>
                                {{ $aviso->visible_desde }} <br/>
                                <i class="fa-regular fa-calendar-xmark"></i>
                                {{$aviso->visible_hasta}} </td>
                            <td class="align-middle pl-3">{!! $aviso->getActivo() !!}</td>
                            <td>{!! Str::words("$aviso->mensaje", 3,' ...') !!}</td>


                            <td class="text-center">

                                <form method="POST" action="{!! route('aviso.aviso.destroy', $aviso->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-sm " role="group">
                                        <a href="{{ route('aviso.aviso.show', $aviso->id ) }}" class="btn btn-info mx-1" title="Ver Aviso">
                                            <span class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></span> Ver
                                        </a>
                                        <a href="{{ route('aviso.aviso.edit', $aviso->id ) }}" class="btn btn-primary mx-1" title="Editar Aviso">
                                            <span class="fa-regular fa-pen-to-square" aria-hidden="true"></span> Editar
                                        </a>

{{--                                        <button type="submit" class="btn btn-danger" title="Delete Aviso" onclick="return confirm(&quot;Click Ok to delete Aviso.&quot;)">--}}
{{--                                            <span class="fa-regular fa-trash-can" aria-hidden="true"></span>--}}
{{--                                        </button>--}}
                                    </div>

                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

            {!! $avisoObjects->links('pagination') !!}
        </div>

        @endif

    </div>
@endsection
