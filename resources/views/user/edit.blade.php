@extends('layouts.app-prueba')
@section('content')
    <div class="container">
        <h4 class="text-info">
            Mi Perfil
        </h4>
        <hr>
        @if(@session('datos_editados'))
            <div class="alert alert-success">
                {{@session('datos_editados')}}
            </div>
        @endif
        @if(@session('contraseña_nueva'))
            <div class="alert alert-success">
                {{@session('contraseña_nueva')}}
            </div>
        @endif
        <div class="row">
            <form class="col-md-4 mb-4" method="POST" action="{{route('editar_usuario')}}">
                @csrf

                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input id="telefono" type="number" class="form-control @error('telefono') is-invalid @enderror"
                           name="telefono" value="{{ $user->telefono }}" required autocomplete="telefono" autofocus>

                    @error('telefono')
                    <span class="invalid-feedback d-block" role="alert">
					<strong>{{ $message }}</strong>
				</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ $user->email }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback d-block" role="alert">
					    <strong>{{ $message }}</strong>
				    </span>
                    @enderror
                </div>

                <input type="submit" value="Editar datos" class="btn btn-secondary">
            </form>
        </div>
        <h3 class="text-secondary">Cambiar contraseña</h3>
        <hr>
        <div class="row">
            <form class="col-md-4" method="POST" action="{{route('cambiar_contra')}}">

                @csrf
                <div class="form-group">
                    <label for="password">Nueva contraseña:</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required/>

                    @error('password')
                    <span class="invalid-feedback d-block" role="alert">
					    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar contraseña:</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required/>
                </div>
                <input type="submit" value="Cambiar" class="btn btn-secondary">
            </form>
        </div>

    </div>
@endsection
