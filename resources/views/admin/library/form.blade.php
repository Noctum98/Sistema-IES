<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre Biblioteca</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($library)->name) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese nombre aquí...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="link" class="col-form-label text-lg-end col-lg-2 col-xl-3">Link</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" name="link" type="text" id="link"
               value="{{ old('link', optional($library)->link) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese link aquí...">
        {!! $errors->first('link', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="orden" class="col-form-label text-lg-end col-lg-2 col-xl-3">Orden</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('orden') ? ' is-invalid' : '' }}" name="orden" type="number" min="0"
               max="99" id="orden"
               value="{{ old('orden', optional($library)->orden) }}" required="required"
               placeholder="Ingrese orden aquí...">
        {!! $errors->first('orden', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

