<div class="mb-3 row">
    <label for="number" class="col-form-label text-lg-end col-lg-2 col-xl-3">Número</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" type="number"
               id="number" value="{{ old('number', optional($libroDigital)->number) }}" min="1" max="4294967295"
               required="required" placeholder="Ingrese número aquí...">
        {!! $errors->first('number', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="resoluciones_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Resoluciones</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('resoluciones_id') ? ' is-invalid' : '' }}" id="resoluciones_id"
                name="resoluciones_id" required="required">
            <option value="" style="display: none;"
                    {{ old('resoluciones_id', optional($libroDigital)->resoluciones_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Seleccione resolución
            </option>
            @foreach ($Resoluciones as $resolution)
                <option
                    value="{{ $resolution['id'] }}" {{ old('resoluciones_id', optional($libroDigital)->resoluciones_id) == $resolution['id'] ? 'selected' : '' }}>
                    {{ $resolution['name']  }} - {{ $resolution['resolution']  }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('resoluciones_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="libros_papeles_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Libro Papel (físico)</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('libros_papeles_id') ? ' is-invalid' : '' }}" id="libros_papeles_id"
                name="libros_papeles_id">
            <option value="" style="display: none;"
                    {{ old('libros_papeles_id', optional($libroDigital)->libros_papeles_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Selecciones libro físico
            </option>
            @foreach ($LibrosPapel as $libroPapel)
                <option
                    value="{{ $libroPapel->id }}" {{ old('libros_papeles_id', optional($libroDigital)->libros_papeles_id) == $libroPapel->id ? 'selected' : '' }}>
                    {{ $libroPapel->name}} - {{ $libroPapel->sede->nombre  }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('libros_papeles_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="fecha_inicio" class="col-form-label text-lg-end col-lg-2 col-xl-3">Fecha Inicio</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('fecha_inicio') ? ' is-invalid' : '' }}" name="fecha_inicio"
               type="date" id="fecha_inicio" value="{{ old('fecha_inicio', optional($libroDigital)->fecha_inicio) }}"
               placeholder="Ingrese fecha inicio aquí...">
        {!! $errors->first('fecha_inicio', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<input type="hidden" name="sede_id" value="{{ $Sede->id }}">

<div class="mb-3 row">
    <label for="observaciones" class="col-form-label text-lg-end col-lg-2 col-xl-3">Observaciones</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('observaciones') ? ' is-invalid' : '' }}" name="observaciones"
               type="text" id="observaciones" value="{{ old('observaciones', optional($libroDigital)->observaciones) }}"
               minlength="1" maxlength="191" required="required" placeholder="Ingrese observaciones aquí...">
        {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<script>

    $(document).ready(function () {
        $('#sede_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione sede",
            allowClear: true
        });
        $('#resoluciones_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione resolución",
            allowClear: true
        });
        $('#libros_papeles_id').select2({
            width: "100%",
            theme: "classic",
            placeholder: "Seleccione libro físico",
            allowClear: true
        });

    });
</script>
