<div class="card mt-3">
    <h5 class="card-header text-secondary">DECLARACIÓN JURADA DE SITUACIÓN ACADÉMICA</h5>
    <div class="card-body">
        <h5 class="card-title text-secondary">A continuación, se explica el carácter de inscripción como estudiante por el cual usted deberá optar en la opción INSCRIPCIÓN A TERCER AÑO. </h5>
        <p class="card-text">
        <p> Usted deberá inscribirse como "ESTUDIANTE REGULAR" a Tercer Año, si: </p>
        <p>a- Tiene todos los espacios curriculares /módulos de primer año acreditados.</p>
        <p>b- A la vez, tiene todos los espacios curriculares / módulos de segundo año regulares y la mitad de los espacios curriculares / módulos de segundo año acreditados. </p>
        <br>
        <p> Deberá inscribirse como "ESTUDIANTE CONDICIONAL" a Tercer Año, si:</p>
        <p>a- Tiene todos los espacios curriculares / módulos de primer año acreditados</p>
        <p>b- A la vez, tiene todos los espacios curriculares / módulos de segundo año regulares.</p>
        <p>c- Y adeuda la acreditación de un espacio curricular / módulo de segundo año para cumplir con la mitad de los espacios / módulo acreditados (Ud. deberá tener el pedido de condicionalidad "aprobado" en su solicitud de excepción al Consejo Académico)</p>
        <br>
        <p>Deberá inscribirse como  "ESTUDIANTE RECURSANTE" a Tercer Año, si</p>
        <p>a- No tiene todos los espacios curriculares / módulos regulares de tercer año. </p>
        <p>Usted deberá consignar los espacios curriculares / módulos de tercer año que debe recursar.</p>
        <h5 class="text-secondary">INSCRIPCIÓN A TERCER AÑO</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="regular_tercero" value="regular_tercero" {{ old('regularidad') == 'regular_tercero' ? 'checked' : '' }}>
            <label class="form-check-label" for="regular_tercero">
                REGULAR
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="condicional_tercero" value="condicional_tercero" {{ old('regularidad') == 'condicional_tercero' ? 'checked' : '' }}>
            <label class="form-check-label" for="condicional_tercero">
                CONDICIONAL
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="recursante_tercero" value="recursante_tercero" {{ old('regularidad') == 'recursante_tercero' ? 'checked' : '' }}>
            <label class="form-check-label" for="recursante_tercero">
                RECURSANTE
            </label>
        </div>
        @include('matriculacion.campos.campos_materias')
    </div>
</div>
