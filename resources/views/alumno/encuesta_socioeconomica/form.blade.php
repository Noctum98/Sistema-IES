@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8 p-3">
    <div class="card text-white bg-primary mb-3">
        <div class="card-header">
            <h2>{{$carrera->sede->nombre.' - '.$carrera->nombre}} - Encuesta Socioeconómica y Motivacional {{ date('Y') }}</h2>
        </div>
        <div class="card-body">
            <p class="card-text">Teniendo en cuenta que nuestra institución trabaja siempre centrando sus acciones en el/la estudiante, es que la siguiente encuesta ha sido confeccionada desde el Área Social y de Políticas Estudiantiles (ASyPE) con el objetivo de elaborar un diagnóstico socioeconómico y motivacional de estudiantes de nuestra oferta educativa.</p>
            <p class="card-text">Los datos que nos aportes al contestar la encuesta, nos permitirán conocer e interpretar tu realidad y la de tus pares; y de esta forma identificar situaciones especiales a tener en cuenta para futuros proyectos y para la planificación de acciones, logrando así la educación integral, que no sólo abarque lo académico, sino también, aspectos que hacen a TU PERSONA.-</p>
            <p class="card-text"> Es por lo mismo que solicitamos completes las siguientes encuestas, dando veracidad a los datos, y siendo consciente que de esta forma puedes PARTICIPAR en la construcción de TU CARRERA PROFESIONAL.-</p>
            <p class="card-text">Los datos aportados, serán reservados solo para el personal Directivo, además del Área Social y de Políticas Estudiantiles (ASyPE), los cuales mantendrán la debida confidencialidad.</b></p>
            <p class="card-text"><b>Muchas gracias por tu colaboración y participación. Equipo de Área Social y de Políticas Estudiantiles.</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Cómo te gusta que te llamen?</h4>
                </label>
                <input type="text" class="form-control mt-2" id="nombre_preferido" name="nombre_preferido" required>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Identidad de género</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios1" value="femenino">
                    <label class="form-check-label" for="exampleRadios1">
                        Femenino
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios2" value="masculino">
                    <label class="form-check-label" for="exampleRadios2">
                        Masculino
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios3" value="transgénero">
                    <label class="form-check-label" for="exampleRadios3">
                        Trangénero
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios3" value="otro">
                    <label class="form-check-label" for="exampleRadios3">
                        Otros
                    </label>
                </div>
                <input type="text" class="form-control mt-2" id="identidad_genero_otra" name="identidad_genero_otra" disabled>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Empresa de servicio de telefonía de tu celular</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono1" value="claro">
                    <label class="form-check-label" for="empresa_telefono1">
                        Claro
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono2" value="movistar">
                    <label class="form-check-label" for="empresa_telefono2">
                        Movistar
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono3" value="personal">
                    <label class="form-check-label" for="empresa_telefono3">
                        Personal
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono3" value="twneti">
                    <label class="form-check-label" for="empresa_telefono3">
                        Twenti
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" id="empresa_telefono3" value="otra">
                    <label class="form-check-label" for="empresa_telefono3">
                        Otra
                    </label>
                </div>
                <input type="text" class="form-control mt-2" id="empresa_telefono" name="empresa_telefono" disabled>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Tenes acceso a internet?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde celular con datos" id="acceso_internet1">
                    <label class="form-check-label" for="acceso_internet1">
                        Desde tu celular, con datos móviles
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde casa en red" id="acceso_internet2">
                    <label class="form-check-label" for="acceso_internet2">
                        Desde tu casa, en red
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde casa de conocido" id="acceso_internet3">
                    <label class="form-check-label" for="acceso_internet3">
                        Desde la casa de un conocido o familiar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde celular familiar" id="acceso_internet4">
                    <label class="form-check-label" for="acceso_internet4">
                        Desde el celular familiar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="no tiene" id="acceso_internet5">
                    <label class="form-check-label" for="acceso_internet5">
                        No tengo acceso a internet
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde red publica o wifi" id="acceso_internet6">
                    <label class="form-check-label" for="acceso_internet6">
                        Desde alguna red publica de WIFI
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="" id="acceso_internet7">
                    <label class="form-check-label" for="acceso_internet7">
                        Otros
                    </label>
                </div>
                <input type="text" class="form-control mt-2" id="empresa_telefono" name="acceso_internet[]" disabled>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Qué herramientas tecnológicas posees?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="tu celular personal" id="herramientas_tecnologicas1">
                    <label class="form-check-label" for="herramientas_tecnologicas1">
                        Tu celular personal
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="pc" id="herramientas_tecnologicas1">
                    <label class="form-check-label" for="herramientas_tecnologicas1">
                        Pc
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="notebook o netbook" id="herramientas_tecnologicas1">
                    <label class="form-check-label" for="herramientas_tecnologicas1">
                        Notebook o netbook
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="tablet" id="herramientas_tecnologicas1">
                    <label class="form-check-label" for="herramientas_tecnologicas1">
                        Tablet
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="celular familiar" id="herramientas_tecnologicas1">
                    <label class="form-check-label" for="herramientas_tecnologicas1">
                        Celular familiar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="no tengo" id="herramientas_tecnologicas1">
                    <label class="form-check-label" for="herramientas_tecnologicas1">
                        No tengo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="" id="herramientas_tecnologicas1">
                    <label class="form-check-label" for="herramientas_tecnologicas1">
                        Otro
                    </label>
                </div>
                <input type="text" class="form-control mt-2" id="herramienta_tecnologica" name="herramientas_tecnologicas[]" disabled>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Durante el ciclo lectivo anterior estuviste vinculado/a a alguna actividad educativa de manera virtual?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="vinculacion_ciclo" id="vinculacion_ciclo1" value="si">
                    <label class="form-check-label" for="vinculacion_ciclo1">
                        Si
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="vinculacion_ciclo" id="vinculacion_ciclo2" value="no">
                    <label class="form-check-label" for="vinculacion_ciclo2">
                        No
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Condición laboral del/ de la estudiante</h4>
                </label>
                <p><i>Ocupada/o: Trabaja para otra persona y le hacen aportes de jubilación y obra social - Independiente: Trabaja para sí o para familiar - Subocupada/o: Trabaja de manera inestable para otra persona pero no le realizan aportes jubilatorio ni le pagan obra social - Desocupada/o: Está buscando activamente trabajo y no encuentra</i></p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral1" value="ocupada/o">
                    <label class="form-check-label" for="condicion_laboral1">
                        Ocupada/o
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral2" value="independiente">
                    <label class="form-check-label" for="condicion_laboral2">
                        Independiente
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral3" value="subocupada/o">
                    <label class="form-check-label" for="condicion_laboral3">
                        Subocupada/o
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral4" value="desocupada/o">
                    <label class="form-check-label" for="condicion_laboral4">
                        Desocupada/o
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral5" value="solo estudio">
                    <label class="form-check-label" for="condicion_laboral5">
                        Solo estudio
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="lugar_y_horario_trabajo" class="text-primary">
                    <h4>Lugar y horario de trabajo</h4>
                </label>
                <p><i>En caso de que trabaje, coloque la empresa/puesto y los días y horarios de trabajo. Si no trabaja, coloque "no trabajo"</i></p>
                <input type="text" class="form-control mt-2" id="lugar_y_horario_trabajo" name="lugar_y_horario_trabajo" required>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Tu trabajo está relacionado con la carrera en la que te has inscripto?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="trabajo_relacionado" id="trabajo_relacionado1" value="si">
                    <label class="form-check-label" for="trabajo_relacionado1">
                        Si
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="trabajo_relacionado" id="trabajo_relacionado2" value="no">
                    <label class="form-check-label" for="trabajo_relacionado2">
                        No
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="trabajo_relacionado" id="trabajo_relacionado3" value="parcialmente">
                    <label class="form-check-label" for="trabajo_relacionado3">
                        Parcialmente
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="trabajo_relacionado" id="trabajo_relacionado4" value="no trabajo">
                    <label class="form-check-label" for="trabajo_relacionado4">
                        No trabajo
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Sos jefe/a de hogar?</h4>
                </label>
                <p><i>Jefe/a de hogar: persona que mantiene económicamente a su grupo conviviente, o que posee el sueldo más alto y estable del grupo conviviente.</i></p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jefe_hogar" id="jefe_hogar1" value="si">
                    <label class="form-check-label" for="jefe_hogar1">
                        Si
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jefe_hogar" id="jefe_hogar2" value="no">
                    <label class="form-check-label" for="jefe_hogar2">
                        No
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Tenés hijos/as a cargo?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hijos_a_cargo" id="hijos_a_cargo1" value="si">
                    <label class="form-check-label" for="hijos_a_cargo1">
                        Si
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="hijos_a_cargo" id="hijos_a_cargo2" value="no">
                    <label class="form-check-label" for="hijos_a_cargo2">
                        No
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Estás embarazada?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="embarazada" id="embarazada1" value="si">
                    <label class="form-check-label" for="embarazada1">
                        Si
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="embarazada" id="embarazada2" value="no">
                    <label class="form-check-label" for="embarazada2">
                        No
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>En caso de que tengas hijos/as, indicá en número ¿Cuántos/as? (si no tenes, colocá 0)</h4>
                </label>
                <input type="number" class="form-control mt-2" id="cantidad_hijos" name="cantidad_hijos" required>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Qué herramientas tecnológicas posees?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="menos de 45 días" id="edad_hijos1">
                    <label class="form-check-label" for="edad_hijos1">
                        Menos de 45 días
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 45 días a 6 meses" id="edad_hijos2">
                    <label class="form-check-label" for="edad_hijos2">
                        De 45 días a 6 meses
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 1 a 3 años" id="edad_hijos3">
                    <label class="form-check-label" for="edad_hijos3">
                        De 1 a 3 años
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="edad_hijos[]" type="checkbox" value=" de 4 y 5 años" id="edad_hijos3">
                    <label class="form-check-label" for="edad_hijos3">
                        De 4 y 5 años
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 6 a 13 años" id="edad_hijos4">
                    <label class="form-check-label" for="edad_hijos4">
                        De 6 a 13 años
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 14 a 18 años" id="edad_hijos6">
                    <label class="form-check-label" for="edad_hijos6">
                        De 14 a 18 años
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 19 a 21 años" id="edad_hijos5">
                    <label class="form-check-label" for="edad_hijos5">
                        De 19 a 21 años
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="más de 21 años" id="edad_hijos7">
                    <label class="form-check-label" for="edad_hijos7">
                        Más de 21 años
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="no tenés hijos" id="edad_hijos8">
                    <label class="form-check-label" for="edad_hijos8">
                        No tenés hijos
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Tenés obra social?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="obra_social" id="obra_social1" value="si">
                    <label class="form-check-label" for="obra_social1">
                        Si
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="obra_social" id="obra_social2" value="no">
                    <label class="form-check-label" for="obra_social2">
                        No
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection