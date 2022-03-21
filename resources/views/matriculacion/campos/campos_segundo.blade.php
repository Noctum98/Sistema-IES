<div class="card mt-3">
    <h5 class="card-header">DECLARACION JURADA DE SITUACIÓN ACADÉMICA</h5>
    <div class="card-body">
        <h5 class="card-title">A continuación se explica el carácter de Inscripción como estudiante por el cuál usted deberá optar en la opción INSCRIPCIÓN A PRIMER AÑO. </h5>
        <p class="card-text">
        <p> Usted podrá inscribirse como <b>"ESTUDIANTE REGULAR"</b> a Segundo Año, sí: </p>
        <p>a- Tiene todos los espacios curriculares/ módulos de Primer año regulares.</p>
        <p>b- Y acreditó (aprobó) la mitad de los espacios curriculares / módulos de primer año. </p>
        <br>
        <p> Deberá inscribirse como <b>"ESTUDIANTE CONDICIONAL"</b> a Segundo Año, sí:</p>
        <p>a- Tiene todos los espacios curriculares / módulos de Primer año regulares.</p>
        <p>b- y adeuda la acreditación de uno o más espacio/s curricular/es / módulos de primer año para cumplir con la mitad de los espacios / módulos acreditados. (Uds. deberá tener el pedido de condicionalidad "aprobado" en su solicitud de excepción al Consejo Académico)</p>
        <br>
        <p>Deberá inscribirse como  <b>"ESTUDIANTE RECURSANTE"</b> a Segundo Año, sí</p>
        <p>a- No regularizó todos los espacios curriculares/módulos de segundo año </p>
        <p>Usted deberá marcar el/los espacios curriculares / módulos que debe recursar</p>
        <br>
        <p>Deberá inscribirse como <b>"ESTUDIANTE RECURSANTE CON TRAYECTORIA DIFERENCIADA EN TERCER AÑO"</b>, sí: </p>
        <p>a- Tiene que recursar espacio/s curricular/es / módulos de segundo año.</p>
        <p>b- y tiene la autorización para cursar espacio/s / módulos de tercer año de manera condicional.</p>
        <p>Usted deberá marcar los espacios curriculares / módulos de Primer año a recursar</p>
        <p>Deberá marcar los espacios curriculares / módulos de Segundo año en el cuál se lo autorizó a cursar. </p>
        </p>
        <h5>INSCRIPCIÓN A SEGUNDO AÑO</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="regular_segundo" value="regular_segundo">
            <label class="form-check-label" for="regular_segundo">
                REGULAR
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="condicional_segundo" value="condicional_segundo">
            <label class="form-check-label" for="condicional_segundo">
                CONDICIONAL
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="recursante_segundo" value="recursante_segundo">
            <label class="form-check-label" for="recursante_segundo">
                RECURSANTE
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="recursante_diferenciado_segundo" value="recursante_diferenciado_segundo">
            <label class="form-check-label" for="recursante_diferenciado_segundo">
                RECURSANTE CON TRAYECTORIA DIFERENCIADA DE CURSADO EN SEGUNDO AÑO
            </label>
        </div>
        @include('matriculacion.campos.campos_materias')
    </div>
</div>