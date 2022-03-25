<div class="form-group">
    <label for="email">Correo Electrónico</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ isset($matriculacion) && $matriculacion->email ? $matriculacion->email: old('email') }}" required />

    @error('email')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>