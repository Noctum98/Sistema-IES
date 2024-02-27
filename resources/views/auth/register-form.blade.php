<div class="form-group row">
    <label for="username" class="col-md-4 col-form-label text-md-right">DNI</label>

    <div class="col-md-6">
        <input id="username" type="number" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

        @error('username')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

    <div class="col-md-6">
        <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>

        @error('nombre')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="apellido" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>

    <div class="col-md-6">
        <input id="apellido" type="text" class="form-control @error('apellido') is-invalid @enderror" name="apellido" value="{{ old('apellido') }}" required autocomplete="apellido" autofocus>

        @error('apellido')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

    <div class="col-md-6">
        <input id="telefono" type="number" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required autocomplete="telefono" autofocus>

        @error('telefono')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo Electronico') }}</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

        @error('email')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" readonly required autocomplete="new-password">

        @error('password')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" readonly>
    </div>
</div>
<div class="form-group row {{ isset($rolesHidden) ? 'd-none' : '' }}">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Seleccione rol') }}</label>
    <div class="col-md-6">
        @foreach($roles as $rol)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $rol->nombre }}" id="rol-{{ $rol->id }}" checked>
            <label class="form-check-label" for="rol-{{ $rol->id }}">
                {{ $rol->descripcion }}
            </label>
        </div>
        @endforeach
    </div>
</div>