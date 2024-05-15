<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($tipoCarrera)->name) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese nombre aquí...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="description" class="col-form-label text-lg-end col-lg-2 col-xl-3">Descripción</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" type="text"
               id="description" value="{{ old('description', optional($tipoCarrera)->description) }}" minlength="1"
               maxlength="191" required="required" placeholder="Ingrese descripción aquí...">
        {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="identifier" class="col-form-label text-lg-end col-lg-2 col-xl-3">Identificador</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('identifier') ? ' is-invalid' : '' }}" name="identifier" type="text"
               id="identifier" value="{{ old('identifier', optional($tipoCarrera)->identifier) }}" minlength="1"
               maxlength="191" required="required" placeholder="Ingrese identificador aquí...">
        {!! $errors->first('identifier', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

