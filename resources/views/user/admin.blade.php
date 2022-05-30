@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <div class="col-sm-12 d-flex">
            <h2 class="h1 text-info  mx-auto">
                Administrar usuarios

            </h2>
            <form class="mx-auto d-inline-flex" action="{{ route('usuarios.admin') }}">
                <div class="input-group mt-3">
                    <input class="form-control mx-auto" type="text" id="search" name="search"
                           placeholder="Buscar usuario" aria-label="Search">
                    <button class="btn btn-outline-primary me-2" type="submit"><i
                                class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="d-flex justify-content-center" style="font-size: 0.8em">
            {{ $users->links() }}
        </div>

        <hr>
        <div class="col-md-12">

            @if(@session('user_deleted'))
                <div class="alert alert-success">
                    {{ @session('user_deleted') }}
                </div>
            @endif
            <a href="{{ route('roles.index') }}" class="btn btn-warning">Administrar Roles</a>

            <table class="table mt-4">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col"><i class="fa fa-cog" style="font-size:20px;"></i></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>
                            <a href="{{ route('usuarios.detalle',$user->id) }}">{{ $user->nombre.' '.$user->apellido }}</a>
                        </td>
                        <td>
                            <form action="{{ route('usuario.eliminar',$user->id) }}" method="POST" class="d-inline">
                                {{ method_field('DELETE') }}
                                <button type="submit" class="ml-2 btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center" style="font-size: 0.8em">
            {{ $users->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/user/carreras.js') }}"></script>
@endsection
