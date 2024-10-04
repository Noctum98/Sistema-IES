<div class="mb-3 row">
    <label for="categoria_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Categoría</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('categoria_id') ? ' is-invalid' : '' }}" id="categoria_id" name="categoria_id" required="true">
            <option value="" style="display: none;" {{ old('categoria_id', optional($ticket)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Selecciona una categoría</option>
            @foreach ($categorias as $key => $categoria)
            <option value="{{ $key }}" {{ old('categoria_id', optional($ticket)->categoria_id) == $key ? 'selected' : '' }}>
                {{ $categoria }}
            </option>
            @endforeach
        </select>

        {!! $errors->first('categoria_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
{{--
<div class="mb-3 row">
    <label for="estado_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Estado</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('estado_id') ? ' is-invalid' : '' }}" id="estado_id" name="estado_id" required="true">
<option value="" style="display: none;" {{ old('estado_id', optional($ticket)->estado_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select estado</option>
@foreach ($estados as $key => $estado)
<option value="{{ $key }}" {{ old('estado_id', optional($ticket)->estado_id) == $key ? 'selected' : '' }}>
    {{ $estado->nombre }}
</option>
@endforeach
</select>

{!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
</div>
</div>

<div class="mb-3 row">
    <label for="ticket_id" class="col-form-label text-lg-end col-lg-2 col-xl-3">Ticket</label>
    <div class="col-lg-10 col-xl-9">
        <select class="form-select{{ $errors->has('ticket_id') ? ' is-invalid' : '' }}" id="ticket_id" name="ticket_id" required="true">
            <option value="" style="display: none;" {{ old('ticket_id', optional($ticket)->ticket_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select ticket</option>
            @foreach ($tickets as $key => $ticket)
            <option value="{{ $key }}" {{ old('ticket_id', optional($ticket)->ticket_id) == $key ? 'selected' : '' }}>
                {{ $ticket }}
            </option>
            @endforeach
        </select>

        {!! $errors->first('ticket_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
--}}
<div class="mb-3 row">
    <label for="asunto" class="col-form-label text-lg-end col-lg-2 col-xl-3">Asunto</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control {{ $errors->has('asunto') ? ' is-invalid' : '' }}" name="asunto" type="text" id="asunto" value="{{ old('asunto', optional($ticket)->asunto) }}" minlength="1" maxlength="191" required="true" placeholder="Ingresa el asunto aqui...">
        {!! $errors->first('asunto', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="descripcion" class="col-form-label text-lg-end col-lg-2 col-xl-3">Descripcion</label>
    <div class="col-lg-10 col-xl-9">
        <textarea class="{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" id="descripcion" required="true" placeholder="Ingresa la descripción aqui...">{{ old('descripcion', optional($ticket)->descripcion) }}</textarea>
        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="image" class="col-form-label text-lg-end col-lg-2 col-xl-3">Captura</label>
    <div class="col-lg-10 col-xl-9">


        <input class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" type="file" id="image" value="{{ old('image', optional($ticket)->captura) }}" minlength="1" maxlength="191" required="true" placeholder="Enter captura here...">
        {!! $errors->first('image', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="url" class="col-form-label text-lg-end col-lg-2 col-xl-3">Url (Opcional)</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" type="text" id="url" value="{{ old('url', optional($ticket)->url) }}" minlength="1" maxlength="191" placeholder="ej: https://data-iesvu.iesvu.edu.ar/mesas/administrar">
        {!! $errors->first('url', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<script>
    Simditor.locale = 'es-AR';
    let editor = new Simditor({
        textarea: $('#descripcion'),
        toolbar: [
            'bold',
            'italic',
            'underline',
            'strikethrough',
            'fontScale',
            'color',
            'ol',
            'ul',
            'blockquote',
            'code',
            'table',
            'link',
            'hr',
            'indent',
            'outdent'
        ]
    });

    /*
    $(document).ready(function () {


        $('#role_destinatario').select2({
            width: "50%",
            placeholder: "Seleccione roles para el mensaje"

        });

    });*/
</script>