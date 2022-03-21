<div class="card mt-3">
    <h5 class="card-header">DECLARACION JURADA DE SITUACIÓN ACADÉMICA</h5>
    <div class="card-body">
        <h5 class="card-title">A continuación se explica el carácter de Inscripción como estudiante por el cuál usted deberá optar en la opción INSCRIPCIÓN A PRIMER AÑO. </h5>
        <p class="card-text">
        <p> Usted deberá inscribirse como "ESTUDIANTE REGULAR" a Tercer Año, sí: </p>
        <p>a- Tiene todos los espacios curriculares /módulos de Primer año acreditados.</p>
        <p>b- A la vez, tiene todos los espacios curriculares / módulos de Segundo año regular y la mitad de los espacios curriculares / módulos de segundo año acreditado. </p>
        <br>
        <p> Deberá inscribirse como "ESTUDIANTE CONDICIONAL" a Segundo Año, sí:</p>
        <p>a- Tiene todos los espacios curriculares / módulos de Primer año acreditados</p>
        <p>b- A la vez, tiene todos los espacios curriculares / módulos de Segundo año regulares.</p>
        <p>c- Y adeuda la acreditación de un ( o más) espacio curricular / módulo de segundo año para cumplir con la mitad de los espacios / módulo acreditados. (Uds. deberá tener el pedido de condicionalidad "aprobado" en su solicitud de excepción al Consejo Académico)</p>
        <br>
        <p>Deberá inscribirse como  "ESTUDIANTE RECURSANTE" a Segundo Año, sí</p>
        <p>a- No tiene todos los espacios curriculares / módulos regulares de tercer año. </p>
        <p>Usted deberá consignar los espacios curriculares / módulos de tercer año que debe recursar.</p>
        <h5>INSCRIPCIÓN A SEGUNDO AÑO</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="regular_tercero" value="regular_tercero">
            <label class="form-check-label" for="regular_tercero">
                REGULAR
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="condicional_tercero" value="condicional_tercero">
            <label class="form-check-label" for="condicional_tercero">
                CONDICIONAL
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="recursante_tercero" value="recursante_tercero">
            <label class="form-check-label" for="recursante_tercero">
                RECURSANTE
            </label>
        </div>
        @include('matriculacion.campos.campos_materias')
    </div>
</div>