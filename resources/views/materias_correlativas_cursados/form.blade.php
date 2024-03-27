
<div class="mb-3 row">
    <label for="materia_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Materia</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('materia_id') ? ' is-invalid' : '' }}" id="materia_id" name="materia_id" required="true">
        	    <option value="" style="display: none;" {{ old('materia_id', optional($materiasCorrelativasCursado)->materia_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select materia</option>
        	@foreach ($Materias as $key => $Materium)
			    <option value="{{ $key }}" {{ old('materia_id', optional($materiasCorrelativasCursado)->materia_id) == $key ? 'selected' : '' }}>
			    	{{ $Materium }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('materia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="previa_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Previa</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('previa_id') ? ' is-invalid' : '' }}" id="previa_id" name="previa_id" required="true">
        	    <option value="" style="display: none;" {{ old('previa_id', optional($materiasCorrelativasCursado)->previa_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select previa</option>
        	@foreach ($Materias as $key => $Materium)
			    <option value="{{ $key }}" {{ old('previa_id', optional($materiasCorrelativasCursado)->previa_id) == $key ? 'selected' : '' }}>
			    	{{ $Materium }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('previa_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="operador_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Operador</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('operador_id') ? ' is-invalid' : '' }}" id="operador_id" name="operador_id" required="true">
        	    <option value="" style="display: none;" {{ old('operador_id', optional($materiasCorrelativasCursado)->operador_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select operador</option>
        	@foreach ($Users as $key => $User)
			    <option value="{{ $key }}" {{ old('operador_id', optional($materiasCorrelativasCursado)->operador_id) == $key ? 'selected' : '' }}>
			    	{{ $User }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('operador_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

