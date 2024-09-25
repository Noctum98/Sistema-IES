
<div class="mb-3 row">
    <label for="nombre" class="col-form-label text-lg-end col-lg-2 col-xl-3">Nombre</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" type="text" id="nombre" value="{{ old('nombre', optional($categoriasTickets)->nombre) }}" minlength="1" maxlength="191" required="true" placeholder="Ingresa un nombre aquí...">
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="horas_de_espera" class="col-form-label text-lg-end col-lg-2 col-xl-3">Horas De Espera</label>
    <div class="col-lg-10 col-xl-9">
        <input class="form-control{{ $errors->has('horas_de_espera') ? ' is-invalid' : '' }}" name="horas_de_espera" type="number" id="horas_de_espera" value="{{ old('horas_de_espera', optional($categoriasTickets)->horas_de_espera) }}" min="-2147483648" max="2147483647" required="true" placeholder="Ingrese las horas de espera aquí...">
        {!! $errors->first('horas_de_espera', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

