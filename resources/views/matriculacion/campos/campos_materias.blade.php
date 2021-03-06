<br>
<div id="primer_año">
    <h6 class="text-secondary">Selecciona las materias a cursar de 1<sup>ro</sup></h6>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ninguna" name="">
        <label class="form-check-label" for="ninguna">
            Ninguna
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="todas-primero" name="">
        <label class="form-check-label" for="todas-primero">
            Todas
        </label>
    </div>
    @foreach($carrera->materias as $materia)
    @if($materia->año == 1)
    <div class="form-check">
        <input class="form-check-input materias-primero" type="checkbox" value="{{ $materia->id }}" id="{{ $materia->id }}" name="materias[]" {{ old('materias') && in_array($materia->id,old('materias')) ? 'checked' : '' }}>
        <label class="form-check-label" for="{{ $materia->id }}">
            {{ $materia->nombre }}
        </label>
    </div>
    @endif
    @endforeach

</div>
<br>
<div id="segundo_año">

    <h6 class="text-secondary">Selecciona las materias a cursar de 2<sup>do</sup></h6>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ninguna" name="">
        <label class="form-check-label" for="todas-primero">
            Ninguna
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input " type="checkbox" value="" id="todas-segundo" name="">
        <label class="form-check-label" for="todas-segundo">
            Todas
        </label>
    </div>
    @foreach($carrera->materias as $materia)
    @if($materia->año == 2)
    <div class="form-check">
        <input class="form-check-input materias-segundo" type="checkbox" value="{{ $materia->id }}" id="{{ $materia->id }}" name="materias[]" {{ old('materias') && in_array($materia->id,old('materias')) ? 'checked' : '' }}>
        <label class="form-check-label" for="{{ $materia->id }}">
            {{ $materia->nombre }}
        </label>
    </div>
    @endif
    @endforeach
</div>
<br>
<div id="tercer_año">
    <h6 class="text-secondary">Selecciona las materias a cursar de 3<sup>ro</sup></h6>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="ninguna" name="">
        <label class="form-check-label" for="todas-primero">
            Ninguna
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="todas-tercero" name="">
        <label class="form-check-label" for="todas-tercero">
            Todas
        </label>
    </div>
    @foreach($carrera->materias as $materia)
    @if($materia->año == 3)
    <div class="form-check">
        <input class="form-check-input materias-tercero" type="checkbox" value="{{ $materia->id }}" id="{{ $materia->id }}" name="materias[]" {{ old('materias') && in_array($materia->id,old('materias')) ? 'checked' : '' }}>
        <label class="form-check-label" for="{{ $materia->id }}">
            {{ $materia->nombre }}
        </label>
    </div>
    @endif
    @endforeach

</div>
