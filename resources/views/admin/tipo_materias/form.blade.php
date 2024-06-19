<div class="mb-3 row">
    <label for="identificador" class="col-form-label text-lg-end col-lg-2 col-xl-3">Identificador</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('identificador') ? ' is-invalid' : '' }}" name="identificador"
               type="number" id="identificador"
               value="{{ old('identificador', optional($tipoMateria)->identificador) }}" min="1"
               max="1000" required="required" placeholder="Ingrese identificador aquí...">
        {!! $errors->first('identificador', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="nombre" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" type="text"
               id="nombre" value="{{ old('nombre', optional($tipoMateria)->nombre) }}" minlength="1" maxlength="191"
               required="required" placeholder="Ingrese nombre aquí...">
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

