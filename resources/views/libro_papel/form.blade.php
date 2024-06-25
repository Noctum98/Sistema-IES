<div class="mb-3 row">
    <label for="name" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($libroPapel)->name) }}" minlength="1" maxlength="191" required="required"
               placeholder="Ingrese nombre aquí...">
        <small class="text-muted">Ej. Libro V Gastronomía</small>
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="number" class="col-form-label text-lg-end col-lg-2 col-xl-3">Número</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" type="number"
               id="number" value="{{ old('number', optional($libroPapel)->number) }}" min="1" max="4294967295"
               required="required" placeholder="Ingrese número aquí...">
        {!! $errors->first('number', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="roman" class="col-form-label text-lg-end col-lg-2 col-xl-3">Romanos</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('roman') ? ' is-invalid' : '' }}" name="roman" type="text" id="roman"
               value="{{ old('roman', optional($libroPapel)->roman) }}" minlength="1" maxlength="191"
               required="required"
               placeholder="Ingrese números romanos aquí...">
        {!! $errors->first('roman', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="acta_inicio" class="col-form-label text-lg-end col-lg-2 col-xl-3">Acta Inicio</label>
    <div class="col-lg-10 col-xl-9">
       <textarea class="form-control{{ $errors->has('mensaje') ? ' is-invalid' : '' }}" name="acta_inicio"
                 id="acta_inicio"
                 placeholder="Ingrese acta inicio aquí...">
           {{ old('acta_inicio', optional($libroPapel)->acta_inicio) }}
       </textarea>
        {!! $errors->first('acta_inicio', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="operador_inicio" class="col-form-label text-lg-end col-lg-2 col-xl-3">Operador Inicio</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('operador_inicio') ? ' is-invalid' : '' }}" name="operador_inicio"
               type="text" id="operador_inicio"
               value="{{ old('operador_inicio', optional($libroPapel)->operador_inicio) }}" minlength="1"
               maxlength="191" required="required" placeholder="Ingrese operador inicio aquí...">
        <small class="text-muted">Persona que firma el acta de inicio</small>
        {!! $errors->first('operador_inicio', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="fecha_inicio" class="col-form-label text-lg-end col-lg-2 col-xl-3">Fecha Inicio</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('fecha_inicio') ? ' is-invalid' : '' }}" name="fecha_inicio"
               type="date" id="fecha_inicio"
               @if(optional($libroPapel)->fecha_inicio)
                   value="{{ Carbon\Carbon::parse($libroPapel->fecha_inicio)->format('Y-m-d') }}"
               @else
                   value="{{ old('fecha_inicio')}}
               @endif

               placeholder="Ingrese fecha inicio aquí...">
        <small class="text-muted">Fecha del acta de inicio</small>
        {!! $errors->first('fecha_inicio', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="sede_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Sede</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('sede_id') ? ' is-invalid' : '' }}" id="sede_id" name="sede_id"
                required="required">
            <option value="" style="display: none;"
                    {{ old('sede_id', optional($libroPapel)->sede_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>
                Seleccione sede
            </option>
            @foreach ($sedes as $key => $sede)
                <option
                    value="{{ $key }}" {{ old('sede_id', optional($libroPapel)->sede_id) == $key ? 'selected' : '' }}>
                    {{ $sede }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('sede_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>


<script>
    Simditor.locale = 'es-AR';
    let editor = new Simditor({
        textarea: $('#acta_inicio'),
        toolbar: ['title', 'bold', 'italic', 'underline', 'fontScale', 'color', '|', 'ol', 'ul', 'blockquote', 'table', '|', 'hr', 'indent', 'outdent', 'alignment'],
    });
    $(document).ready(function () {
        $('#sede_id').select2({
            width: "100%",
            theme: "bootstrap",
            placeholder: "Seleccione sede",
            allowClear: true
        });

    });
</script>
