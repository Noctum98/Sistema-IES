
<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Name</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($tipoInstancia)->name) }}" minlength="1" maxlength="255" placeholder="Enter name here...">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="identifier" class="col-form-label text-lg-end col-lg-2 col-xl-3">Identifier</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('identifier') ? ' is-invalid' : '' }}" name="identifier" type="text" id="identifier" value="{{ old('identifier', optional($tipoInstancia)->identifier) }}" minlength="1" placeholder="Enter identifier here...">
        {!! $errors->first('identifier', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

