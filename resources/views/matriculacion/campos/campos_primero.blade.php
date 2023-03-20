<div class="card mt-3">
    <h5 class="card-header text-secondary">DECLARACIÓN JURADA DE SITUACIÓN ACADÉMICA</h5>
    <div class="card-body">
        <h5 class="card-title">A continuación, se explica el carácter de inscripción como estudiante por el cual usted deberá optar en la opción INSCRIPCIÓN A PRIMER AÑO. </h5>
        <p class="card-text">
        <p> Usted deberá inscribirse como <b>"ESTUDIANTE REGULAR"</b> a Primer Año, si: </p>
        <p>a- Presentó toda la documentación requerida para el completamiento del Legajo.</p>
        <p>b- Concluyó los estudios de nivel medio y/o aprobó el ingreso por Art. 7mo. </p>
        <p>c- Completó el INGRESO al IESVU por medio de los procesos académicos previstos.</p>
        <p>d- Fue notificado formalmente de su ingreso a la carrera solicitada por parte de la institución. </p>
        <br>
        <p> Deberá inscribirse como <b>“ESTUDIANTE CONDICIONAL"</b> a Primer Año, si:</p>
        <p>(Cuando se adeuda alguno o varios de los requisitos de ingreso)</p>
        <p>a- Adeuda documentación requerida para el completamiento del Legajo.</p>
        <p>b- Adeuda espacios curriculares de nivel medio.</p>
        <p>c- Adeuda instancias del INGRESO al IESVU.</p>
        <br>
        <p>Deberá inscribirse como <b>"ESTUDIANTE RECURSANTE"</b> a Primer Año:</p>
        <p>a- Cuando no regularizó todos los espacios curriculares / módulos de primer año. </p>
        <p>Usted deberá marcar el/los espacios curriculares / módulos que debe recursar.</p>
        <br>
        <p>Deberá inscribirse como <b>"ESTUDIANTE RECURSANTE CON TRAYECTORIA DIFERENCIADA EN SEGUNDO AÑO":</b> </p>
        <p>a- Cuando no regularizó todos los espacios curriculares / módulos de primer año.</p>
        <p>b- A la vez, tener autorización para cursar espacios / módulos del año siguiente superior no correlativos al espacio / módulo que recursa.</p>
        <p>Usted deberá marcar los espacios curriculares / módulos de primer año a recursar.</p>
        <p>Deberá marcar los espacios curriculares / módulos de segundo año en los cuales se lo autorizó a cursar. </p>
        </p>
        <h5>INSCRIPCIÓN A PRIMER AÑO</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="regular_primero" value="regular_primero" {{ old('regularidad') == 'regular_primero' ? 'checked' : '' }} />
            <label class="form-check-label" for="regular_primero">
                REGULAR
            </label>
        </div>
        @if(Auth::user())
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="condicional_primero" value="condicional_primero" {{ old('regularidad') == 'condicional_primero' ? 'checked' : '' }}>
            <label class="form-check-label" for="condicional_primero">
                CONDICIONAL
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="recursante_primero" value="recursante_primero" {{ old('regularidad') == 'recursante_primero' ? 'checked' : '' }}>
            <label class="form-check-label" for="recursante_primero">
                RECURSANTE
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="regularidad" id="recursante_diferenciado_primero" value="recursante_diferenciado_primero" {{ old('regularidad') == 'recursante_diferenciado_primero' ? 'checked' : '' }}>
            <label class="form-check-label" for="recursante_diferenciado_primero">
                RECURSANTE CON TRAYECTORIA DIFERENCIADA DE CURSADO EN SEGUNDO AÑO
            </label>
        </div>
        @endif
        @include('matriculacion.campos.campos_materias')
    </div>
</div>
