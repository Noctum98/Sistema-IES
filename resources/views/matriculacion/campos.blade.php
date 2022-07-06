<div class="form-group">
    <label for="email">Correo Electrónico</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ isset($matriculacion) && $matriculacion->email ? $matriculacion->email: old('email') }}" required />

    @error('email')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group">
    <label for="cohorte">Cohorte:</label>
    <input type="text" id="cohorte" name="cohorte"
           class="form-control @error('cohorte') is-invalid @enderror" value="{{ $matriculacion->cohorte }}"
           required/>

    @error('cohorte')
    <span class="invalid-feedback d-block" role="alert">
						    <strong>{{ $message }}</strong>
						</span>
    @enderror
</div>
<div class="form-group">
    <div class="form-group col-md-6">
        <label for="active">Activo: </label>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="active" id="active-si" value="1" {{ isset($matriculacion) && $matriculacion->active == 1 || old('active') ? 'checked' : '' }}>
            <label class="form-check-label" for="active-si">
                 Si
            </label>
        </div>
        <div class="form-check-inline">
            <input class="form-check-input" type="radio" name="active" id="active-no" value="0" {{ isset($matriculacion) && $matriculacion->active == 0 ? 'checked' : '' }}>
            <label class="form-check-label" for="active-no">
                 No
            </label>
        </div>
    </div>
</div>