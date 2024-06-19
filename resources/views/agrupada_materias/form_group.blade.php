<div class="mb-3 row">
    <h4 class="col-form-label text-lg-end col-lg-2 col-xl-3">
        Correlatividad Agrupada <b>{{ $correlatividadAgrupada->name }}</b>
    </h4>
    <input type="hidden" id="correlatividad_agrupada_id" name="correlatividad_agrupada_id"
           value="{{ old('correlatividad_agrupada_id', optional($correlatividadAgrupada)->id) }}">
</div>
<div class="mb-3 row">
    <label for="master_materia_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Master Materia</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('master_materia_id') ? ' is-invalid' : '' }}" id="master_materia_id"
                name="master_materia_id[]" required="required" multiple="multiple">
            <option value="" style="display: none;"
            @foreach ($MasterMaterias as $key => $masterMateria)
                @if(in_array($key, $correlatividadAgrupada->agrupadaMaterias->pluck('master_materia_id')->toArray()))
                    <option value="{{ $key }}" selected="selected">
                        {{ $masterMateria }}
                    </option>
                @else

                    <option value="{{ $key }}">
                        {{ $masterMateria }}
                    </option>

                @endif

            @endforeach
        </select>

        {!! $errors->first('master_materia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>




