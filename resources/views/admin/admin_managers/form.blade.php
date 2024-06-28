<div class="mb-3 row">
    <label for="enabled" class="col-form-label text-lg-end col-lg-2 col-xl-3">Habilitado</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox">
            <input id="enabled_1" class="form-check-input" name="enabled" type="checkbox"
                   value="1" {{ old('enabled', optional($adminManager)->enabled) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="enabled_1">
                Yes
            </label>
        </div>


        {!! $errors->first('enabled', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="icon" class="col-form-label text-lg-end col-lg-2 col-xl-3">Icon</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('icon') ? ' is-invalid' : '' }}" name="icon" type="text" id="icon"
               value="{{ old('icon', optional($adminManager)->icon) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese icon aquí...">
        {!! $errors->first('icon', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="link" class="col-form-label text-lg-end col-lg-2 col-xl-3">Link</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" name="link" type="text" id="link"
               value="{{ old('link', optional($adminManager)->link) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese link aquí...">
        {!! $errors->first('link', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="model" class="col-form-label text-lg-end col-lg-2 col-xl-3">Model</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" name="model" type="text" id="model"
               value="{{ old('model', optional($adminManager)->model) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese model aquí...">
        {!! $errors->first('model', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($adminManager)->name) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese nombre here...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

