
<div class="mb-3 row">
    <label for="folio" class="col-form-label text-lg-end col-lg-2 col-xl-3">Folio</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('folio') ? ' is-invalid' : '' }}" name="folio" type="number" id="folio" value="{{ old('folio', optional($libros)->folio) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter folio here...">
        {!! $errors->first('folio', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="llamado" class="col-form-label text-lg-end col-lg-2 col-xl-3">Llamado</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('llamado') ? ' is-invalid' : '' }}" name="llamado" type="text" id="llamado" value="{{ old('llamado', optional($libros)->llamado) }}" minlength="1" required="true" placeholder="Enter llamado here...">
        {!! $errors->first('llamado', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="mesa_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Mesa</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('mesa_id') ? ' is-invalid' : '' }}" id="mesa_id" name="mesa_id" required="true">
        	    <option value="" style="display: none;" {{ old('mesa_id', optional($libros)->mesa_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select mesa</option>
        	@foreach ($mesas as $key => $mesa)
			    <option value="{{ $key }}" {{ old('mesa_id', optional($libros)->mesa_id) == $key ? 'selected' : '' }}>
			    	{{ $mesa }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('mesa_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="numero" class="col-form-label text-lg-end col-lg-2 col-xl-3">Numero</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('numero') ? ' is-invalid' : '' }}" name="numero" type="number" id="numero" value="{{ old('numero', optional($libros)->numero) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter numero here...">
        {!! $errors->first('numero', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="orden" class="col-form-label text-lg-end col-lg-2 col-xl-3">Orden</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('orden') ? ' is-invalid' : '' }}" name="orden" type="number" id="orden" value="{{ old('orden', optional($libros)->orden) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter orden here...">
        {!! $errors->first('orden', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

