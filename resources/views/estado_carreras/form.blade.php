<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($estadoCarrera)->name) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese nombre aqui...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="identifier" class="col-form-label text-lg-end col-lg-2 col-xl-3">Identificador</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('identifier') ? ' is-invalid' : '' }}" name="identifier" type="text"
               id="identifier" value="{{ old('identifier', optional($estadoCarrera)->identifier) }}" minlength="1"
               maxlength="191" required="required" placeholder="Ingrese identificador aquí...">
        {!! $errors->first('identifier', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="disabled" class="col-form-label text-lg-end col-lg-2 col-xl-3">Deshabilitado</label>
    <div class="col-lg-10 col-xl-9">
        <div class="form-check checkbox">
            <input id="disabled_1" class="form-check-input" name="disabled" type="checkbox"
                   value="1" {{ old('disabled', optional($estadoCarrera)->disabled) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="disabled_1">
                Si
            </label>
        </div>


        {!! $errors->first('disabled', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
