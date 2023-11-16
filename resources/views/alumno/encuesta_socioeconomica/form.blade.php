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

    <form action="{{ route('encuesta_socioeconomica.store') }}" method="POST">
        <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
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
                        <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios1" value="femenino" {{ old('identidad_genero') == 'femenino' ? 'checked' : '' }}>
                        <label class="form-check-label" for="exampleRadios1">
                            Femenino
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios2" value="masculino" {{ old('identidad_genero') == 'masculino' ? 'checked' : '' }}>
                        <label class="form-check-label" for="exampleRadios2">
                            Masculino
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="identidad_genero" id="exampleRadios3" value="transgénero" {{ old('identidad_genero') == 'transgénero' ? 'checked' : '' }}>
                        <label class="form-check-label" for="exampleRadios3">
                            Trangénero
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="identidad_genero" id="identidad_genero_4" value="otro" {{ old('identidad_genero') == 'otro' ? 'checked' : '' }}>
                        <label class="form-check-label" for="identidad_genero_4">
                            Otros
                        </label>
                    </div>
                    <div class="form-group d-none" id="otra_identidad_genero">
                        <label for="identidad_genero_otra">Cual?</label>
                        <input type="text" class="form-control mt-2" id="identidad_genero_otra" name="identidad_genero_otra" value="{{ old('identidad_genero_otra') }}" {{ old('identidad_genero') != 'otro' ? 'checked' : '' }}>
                    </div>
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
                        <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono1" value="claro" {{ old('empresa_telefono') == 'claro' ? 'checked' : '' }}>
                        <label class="form-check-label" for="empresa_telefono1">
                            Claro
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono2" value="movistar" {{ old('empresa_telefono') == 'movistar' ? 'checked' : '' }}>
                        <label class="form-check-label" for="empresa_telefono2">
                            Movistar
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono3" value="personal" {{ old('empresa_telefono') == 'personal' ? 'checked' : '' }}>
                        <label class="form-check-label" for="empresa_telefono3">
                            Personal
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono4" value="twneti" {{ old('empresa_telefono') == 'twneti' ? 'checked' : '' }}>
                        <label class="form-check-label" for="empresa_telefono4">
                            Twenti
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="empresa_telefono" id="empresa_telefono5" value="otra" {{ old('empresa_telefono') == 'otra' ? 'checked' : '' }}>
                        <label class="form-check-label" for="empresa_telefono5">
                            Otra
                        </label>
                    </div>
                    <div class="form-group d-none" id="otra_telefono">
                        <label for="empresa_telefonoOtra">Cual?</label>
                        <input type="text" class="form-control mt-2" id="empresa_telefonoOtra" name="empresa_telefono" value="{{ old('empresa_telefono') }}" {{ old('empresa_telefono') == 'otra' ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>¿Tienes acceso a internet?</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde celular con datos" id="acceso_internet1" {{ in_array('desde celular con datos', old('acceso_internet', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="acceso_internet1">
                            Desde tu celular, con datos móviles
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde casa en red" id="acceso_internet2" {{ in_array('desde casa en red', old('acceso_internet', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="acceso_internet2">
                            Desde tu casa, en red
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde casa de conocido" id="acceso_internet3" {{ in_array('desde casa de conocido', old('acceso_internet', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="acceso_internet3">
                            Desde la casa de un conocido o familiar
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde celular familiar" id="acceso_internet4" {{ in_array('desde celular familiar', old('acceso_internet', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="acceso_internet4">
                            Desde el celular familiar
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="no tiene" id="acceso_internet5" {{ in_array('no tiene', old('acceso_internet', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="acceso_internet5">
                            No tengo acceso a internet
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="desde red publica o wifi" id="acceso_internet6" {{ in_array('desde red publica o wifi', old('acceso_internet', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="acceso_internet6">
                            Desde alguna red pública de WIFI
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="acceso_internet[]" type="checkbox" value="" id="acceso_internet7" {{ in_array('', old('acceso_internet', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="acceso_internet7">
                            Otros
                        </label>
                    </div>
                    <div class="form-group d-none" id="otra_acceso">
                        <label for="acceso_otro">Cual?</label>
                        <input type="text" class="form-control mt-2" id="acceso_otro" name="acceso_internet[]" value="{{ old('acceso_internet_otro') }}" {{ in_array('', old('acceso_internet', [])) ? 'checked' : '' }}>
                    </div>
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
                        <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="tu celular personal" id="herramientas_tecnologicas1" {{ in_array('tu celular personal', old('herramientas_tecnologicas', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="herramientas_tecnologicas1">
                            Tu celular personal
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="pc" id="herramientas_tecnologicas2" {{ in_array('pc', old('herramientas_tecnologicas', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="herramientas_tecnologicas2">
                            Pc
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="notebook o netbook" id="herramientas_tecnologicas3" {{ in_array('notebook o netbook', old('herramientas_tecnologicas', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="herramientas_tecnologicas3">
                            Notebook o netbook
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="tablet" id="herramientas_tecnologicas4" {{ in_array('tablet', old('herramientas_tecnologicas', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="herramientas_tecnologicas4">
                            Tablet
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="celular familiar" id="herramientas_tecnologicas5" {{ in_array('celular familiar', old('herramientas_tecnologicas', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="herramientas_tecnologicas5">
                            Celular familiar
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="no tengo" id="herramientas_tecnologicas6" {{ in_array('no tengo', old('herramientas_tecnologicas', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="herramientas_tecnologicas6">
                            No tengo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="herramientas_tecnologicas[]" type="checkbox" value="" id="herramientas_tecnologicas7" {{ in_array('', old('herramientas_tecnologicas', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="herramientas_tecnologicas7">
                            Otro
                        </label>
                    </div>
                    <input type="text" class="form-control mt-2" id="herramienta_tecnologica" name="herramientas_tecnologicas_otro" value="{{ old('herramientas_tecnologicas_otro') }}" {{ in_array('', old('herramientas_tecnologicas', [])) ? 'checked' : '' }}>
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
                        <input class="form-check-input" type="radio" name="vinculacion_ciclo" id="vinculacion_ciclo1" value="si" {{ old('vinculacion_ciclo') == 'si' ? 'checked' : '' }}>
                        <label class="form-check-label" for="vinculacion_ciclo1">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="vinculacion_ciclo" id="vinculacion_ciclo2" value="no" {{ old('vinculacion_ciclo') == 'no' ? 'checked' : '' }}>
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
                        <h4>Condición laboral del/de la estudiante</h4>
                    </label>
                    <p><i>Ocupada/o: Trabaja para otra persona y le hacen aportes de jubilación y obra social - Independiente: Trabaja para sí o para familiar - Subocupada/o: Trabaja de manera inestable para otra persona pero no le realizan aportes jubilatorio ni le pagan obra social - Desocupada/o: Está buscando activamente trabajo y no encuentra</i></p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral1" value="ocupada/o" {{ old('condicion_laboral') == 'ocupada/o' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_laboral1">
                            Ocupada/o
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral2" value="independiente" {{ old('condicion_laboral') == 'independiente' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_laboral2">
                            Independiente
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral3" value="subocupada/o" {{ old('condicion_laboral') == 'subocupada/o' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_laboral3">
                            Subocupada/o
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral4" value="desocupada/o" {{ old('condicion_laboral') == 'desocupada/o' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_laboral4">
                            Desocupada/o
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral" id="condicion_laboral5" value="solo estudio" {{ old('condicion_laboral') == 'solo estudio' ? 'checked' : '' }}>
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
                    <input type="text" class="form-control mt-2" id="lugar_y_horario_trabajo" name="lugar_y_horario_trabajo" value="{{ old('lugar_y_horario_trabajo') }}" required>
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
                        <input class="form-check-input" type="radio" name="trabajo_relacionado" id="trabajo_relacionado1" value="si" {{ old('trabajo_relacionado') == 'si' ? 'checked' : '' }}>
                        <label class="form-check-label" for="trabajo_relacionado1">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="trabajo_relacionado" id="trabajo_relacionado2" value="no" {{ old('trabajo_relacionado') == 'no' ? 'checked' : '' }}>
                        <label class="form-check-label" for="trabajo_relacionado2">
                            No
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="trabajo_relacionado" id="trabajo_relacionado3" value="parcialmente" {{ old('trabajo_relacionado') == 'parcialmente' ? 'checked' : '' }}>
                        <label class="form-check-label" for="trabajo_relacionado3">
                            Parcialmente
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="trabajo_relacionado" id="trabajo_relacionado4" value="no trabajo" {{ old('trabajo_relacionado') == 'no trabajo' ? 'checked' : '' }}>
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
                        <input class="form-check-input" type="radio" name="jefe_hogar" id="jefe_hogar1" value="si" {{ old('jefe_hogar') == 'si' ? 'checked' : '' }}>
                        <label class="form-check-label" for="jefe_hogar1">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jefe_hogar" id="jefe_hogar2" value="no" {{ old('jefe_hogar') == 'no' ? 'checked' : '' }}>
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
                        <input class="form-check-input" type="radio" name="hijos_a_cargo" id="hijos_a_cargo1" value="si" {{ old('hijos_a_cargo') == 'si' ? 'checked' : '' }}>
                        <label class="form-check-label" for="hijos_a_cargo1">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="hijos_a_cargo" id="hijos_a_cargo2" value="no" {{ old('hijos_a_cargo') == 'no' ? 'checked' : '' }}>
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
                        <input class="form-check-input" type="radio" name="embarazada" id="embarazada1" value="si" {{ old('embarazada') == 'si' ? 'checked' : '' }}>
                        <label class="form-check-label" for="embarazada1">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="embarazada" id="embarazada2" value="no" {{ old('embarazada') == 'no' ? 'checked' : '' }}>
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
                    <input type="number" class="form-control mt-2" id="cantidad_hijos" name="cantidad_hijos" value="{{ old('cantidad_hijos') }}" required>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Edad de tus hijos:</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="menos de 45 días" id="edad_hijos1" {{ is_array(old('edad_hijos')) && in_array('menos de 45 días', old('edad_hijos')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edad_hijos1">
                            Menos de 45 días
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 45 días a 6 meses" id="edad_hijos2" {{ is_array(old('edad_hijos')) && in_array('de 45 días a 6 meses', old('edad_hijos')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edad_hijos2">
                            De 45 días a 6 meses
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 1 a 3 años" id="edad_hijos3" {{ is_array(old('edad_hijos')) && in_array('de 1 a 3 años', old('edad_hijos')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edad_hijos3">
                            De 1 a 3 años
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="edad_hijos[]" type="checkbox" value=" de 4 y 5 años" id="edad_hijos3" {{ is_array(old('edad_hijos')) && in_array('de 4 y 5 años', old('edad_hijos')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edad_hijos3">
                            De 4 y 5 años
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 6 a 13 años" id="edad_hijos4" {{ is_array(old('edad_hijos')) && in_array('de 6 a 13 años', old('edad_hijos')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edad_hijos4">
                            De 6 a 13 años
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 14 a 18 años" id="edad_hijos6" {{ is_array(old('edad_hijos')) && in_array('de 14 a 18 años', old('edad_hijos')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edad_hijos6">
                            De 14 a 18 años
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="de 19 a 21 años" id="edad_hijos5" {{ is_array(old('edad_hijos')) && in_array('de 19 a 21 años', old('edad_hijos')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edad_hijos5">
                            De 19 a 21 años
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="más de 21 años" id="edad_hijos7" {{ is_array(old('edad_hijos')) && in_array('más de 21 años', old('edad_hijos')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="edad_hijos7">
                            Más de 21 años
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="edad_hijos[]" type="checkbox" value="no tenés hijos" id="edad_hijos8" {{ is_array(old('edad_hijos')) && in_array('no tenés hijos', old('edad_hijos')) ? 'checked' : '' }}>
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
                        <input class="form-check-input" type="radio" name="obra_social" id="obra_social1" value="si" {{ old('obra_social') == 'si' ? 'checked' : '' }}>
                        <label class="form-check-label" for="obra_social1">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="obra_social" id="obra_social2" value="no" {{ old('obra_social') == 'no' ? 'checked' : '' }}>
                        <label class="form-check-label" for="obra_social2">
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
                        <h4>Recibis:</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" name="subsidios[]" type="checkbox" value="PROGRESAR/ PRONAFE" id="subsidios1" {{ in_array('PROGRESAR/ PRONAFE', old('subsidios', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subsidios1">
                            PROGRESAR/ PRONAFE
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="subsidios[]" type="checkbox" value="medio boleto" id="subsidios2" {{ in_array('medio boleto', old('subsidios', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subsidios2">
                            Medio boleto estudiantil de Vías y Medios de transporte
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="subsidios[]" type="checkbox" value="beca municipal" id="subsidios3" {{ in_array('beca municipal', old('subsidios', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subsidios3">
                            Beca Municipal
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="subsidios[]" type="checkbox" value="beca de transporte" id="subsidios4" {{ in_array('beca de transporte', old('subsidios', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subsidios4">
                            Beca de Transporte
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="subsidios[]" type="checkbox" value="beca de fotocopias" id="subsidios5" {{ in_array('beca de fotocopias', old('subsidios', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subsidios5">
                            Beca de fotocopias
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="subsidios[]" type="checkbox" value="aporte por capacitación" id="subsidios6" {{ in_array('aporte por capacitación', old('subsidios', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subsidios6">
                            Aporte por capacitación de parte de la empresa en la que trabajas
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="subsidios[]" type="checkbox" value="IFE O Plan social" id="subsidios8" {{ in_array('IFE O Plan social', old('subsidios', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subsidios8">
                            IFE O Plan social
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="subsidios[]" type="checkbox" value="no recibo Ninguna" id="subsidios9" {{ in_array('no recibo Ninguna', old('subsidios', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subsidios9">
                            No recibo Ninguna
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Si te has inscripto en PROGRESAR en el ciclo lectivo 2022, te pedimos que adjuntes comprobante</h4>
                    </label>
                    <input type="file" class="form-control mt-2" id="comprobanete_progresar" name="comprobanete_progresar" value="{{ old('comprobanete_progresar') }}">
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Kilómetros de distancia desde tu domicilio hasta el IES</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies1" value="menos de 1 Km." {{ old('distancia_ies') === 'menos de 1 Km.' ? 'checked' : '' }}>
                        <label class="form-check-label" for="distancia_ies1">
                            Menos de 1 Km.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies2" value="desde 1,1 Km. a 3 Km." {{ old('distancia_ies') === 'desde 1,1 Km. a 3 Km.' ? 'checked' : '' }}>
                        <label class="form-check-label" for="distancia_ies2">
                            Desde 1,1 Km. a 3 Km.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies3" value="desde 3,1 km a 7 km" {{ old('distancia_ies') === 'desde 3,1 km a 7 km' ? 'checked' : '' }}>
                        <label class="form-check-label" for="distancia_ies3">
                            Desde 3,1 km a 7 km
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies4" value="desde 7,1 a 15 Km." {{ old('distancia_ies') === 'desde 7,1 a 15 Km.' ? 'checked' : '' }}>
                        <label class="form-check-label" for="distancia_ies4">
                            Desde 7,1 a 15 Km.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies5" value="desde 15,1 Km. a  25 Km." {{ old('distancia_ies') === 'desde 15,1 Km. a  25 Km.' ? 'checked' : '' }}>
                        <label class="form-check-label" for="distancia_ies5">
                            Desde 15,1 Km. a 25 Km.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies6" value="desde 25,1 Km. a 35 km." {{ old('distancia_ies') === 'desde 25,1 Km. a 35 km.' ? 'checked' : '' }}>
                        <label class="form-check-label" for="distancia_ies6">
                            Desde 25,1 Km. a 35 km.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies7" value="desde 35,1 Km. a 45 Km." {{ old('distancia_ies') === 'desde 35,1 Km. a 45 Km.' ? 'checked' : '' }}>
                        <label class="form-check-label" for="distancia_ies7">
                            Desde 35,1 Km. a 45 Km.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies8" value="más de 45,1 Km." {{ old('distancia_ies') === 'más de 45,1 Km.' ? 'checked' : '' }}>
                        <label class="form-check-label" for="distancia_ies8">
                            Más de 45,1 Km.
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Transporte utilizado para concurrir al IES</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="colectivo" id="transporte_utilizado1" {{ in_array('colectivo', old('transporte_utilizado', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="transporte_utilizado1">
                            Colectivo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="auto propio" id="transporte_utilizado2" {{ in_array('auto propio', old('transporte_utilizado', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="transporte_utilizado2">
                            Auto propio
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="auto de otra persona" id="transporte_utilizado3" {{ in_array('auto de otra persona', old('transporte_utilizado', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="transporte_utilizado3">
                            Auto de otra persona
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="caminando un trayecto mayor de 3 Km." id="transporte_utilizado4" {{ in_array('caminando un trayecto mayor de 3 Km.', old('transporte_utilizado', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="transporte_utilizado4">
                            Caminando un trayecto mayor de 3 Km.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="caminando un trayecto menor a 3 Km." id="transporte_utilizado5" {{ in_array('caminando un trayecto menor a 3 Km.', old('transporte_utilizado', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="transporte_utilizado5">
                            Caminando un trayecto menor a 3 Km.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="bicicleta" id="transporte_utilizado6" {{ in_array('bicicleta', old('transporte_utilizado', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="transporte_utilizado6">
                            Bicicleta
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="moto" id="transporte_utilizado7" {{ in_array('moto', old('transporte_utilizado', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="transporte_utilizado7">
                            Moto
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Cantidad de personas que conviven con vos</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes1" value="vivo solo" {{ old('cantidad_convivientes') == 'vivo solo' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cantidad_convivientes1">
                            Vivo solo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes2" value="de 1 a 2 personas" {{ old('cantidad_convivientes') == 'de 1 a 2 personas' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cantidad_convivientes2">
                            De 1 a 2 personas
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes3" value="de 3 a 4 personas" {{ old('cantidad_convivientes') == 'de 3 a 4 personas' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cantidad_convivientes3">
                            De 3 a 4 personas
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes4" value="de 5 a 6 personas" {{ old('cantidad_convivientes') == 'de 5 a 6 personas' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cantidad_convivientes4">
                            De 5 a 6 personas
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes5" value="más de 7 personas" {{ old('cantidad_convivientes') == 'más de 7 personas' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cantidad_convivientes5">
                            Más de 7 personas
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Cantidad de lugares para dormir que posee tu vivienda</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cantidad_lugares_dormir" id="cantidad_lugares_dormir1" value="monoambiente" {{ old('cantidad_lugares_dormir') == 'monoambiente' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cantidad_lugares_dormir1">
                            Mi vivienda es un monoambiente (No posee separado los espacios de comida y descanso)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cantidad_lugares_dormir" id="cantidad_lugares_dormir2" value="solo una habitacion" {{ old('cantidad_lugares_dormir') == 'solo una habitacion' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cantidad_lugares_dormir2">
                            Posee solo una habitación exclusiva para dormir
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cantidad_lugares_dormir" id="cantidad_lugares_dormir3" value="dos habitaciones" {{ old('cantidad_lugares_dormir') == 'dos habitaciones' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cantidad_lugares_dormir3">
                            Posee dos habitaciones para dormir
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cantidad_lugares_dormir" id="cantidad_lugares_dormir4" value="tres o mas habitaciones" {{ old('cantidad_lugares_dormir') == 'tres o mas habitaciones' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cantidad_lugares_dormir4">
                            Posee tres o más habitaciones para dormir
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Ingresos mensuales del grupo familiar</h4>
                    </label>
                    <p><i>Colocar el monto aproximado de ingresos que tiene el grupo familiar conviviente mensualmente.</i></p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ingresos_mensuales" id="ingresos_mensuales1" value="Menos de $50000" {{ old('ingresos_mensuales') == 'Menos de $50000' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingresos_mensuales1">
                            Menos de $ 50000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ingresos_mensuales" id="ingresos_mensuales2" value="Entre $50.0001 y $ 80.000" {{ old('ingresos_mensuales') == 'Entre $50.0001 y $ 80.000' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingresos_mensuales2">
                            Entre $50.0001 y $ 80.000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ingresos_mensuales" id="ingresos_mensuales3" value="Entre $80.001 y 100.000" {{ old('ingresos_mensuales') == 'Entre $80.001 y 100.000' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingresos_mensuales3">
                            Entre $80.001 y 100.000
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="ingresos_mensuales" id="ingresos_mensuales4" value="Más de $ 100.001" {{ old('ingresos_mensuales') == 'Más de $ 100.001' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ingresos_mensuales4">
                            Más de $ 100.001
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Condición laboral del Jefe/a de hogar</h4>
                    </label>
                    <p><i>Recuerda que la/el jefa/e de hogar es aquella persona conviviente con mayor ingreso. Ocupada/o: Trabaja para otra persona y le hacen aportes de jubilación y obra social - Independiente: Trabaja para sí mismo o para familiar - Subocupada/o: Trabaja de manera inestable para otra persona pero no le realizan aportes jubilatorio ni le pagan obra social - Desocupada/o: Está buscando activamente trabajo y no encuentra.</i></p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar1" value="Ocupada/o" {{ old('condicion_laboral_jefe_hogar') == 'Ocupada/o' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_laboral_jefe_hogar1">
                            Ocupada/o
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar2" value="Independiente" {{ old('condicion_laboral_jefe_hogar') == 'Independiente' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_laboral_jefe_hogar2">
                            Independiente
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar3" value="Subocupada/o" {{ old('condicion_laboral_jefe_hogar') == 'Subocupada/o' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_laboral_jefe_hogar3">
                            Subocupada/o
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar4" value="Desocupada/o" {{ old('condicion_laboral_jefe_hogar') == 'Desocupada/o' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_laboral_jefe_hogar4">
                            Desocupada/o
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar5" value="Jubilada/o o Pensionada/o" {{ old('condicion_laboral_jefe_hogar') == 'Jubilada/o o Pensionada/o' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_laboral_jefe_hogar5">
                            Jubilada/o o Pensionada/o
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Máximo nivel educativo alcanzado por el Padre</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre1" value="Analfabeto" {{ old('maximo_nivel_educativo_padre') == 'Analfabeto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_padre1">
                            Analfabeto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre2" value="Primario incompleto" {{ old('maximo_nivel_educativo_padre') == 'Primario incompleto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_padre2">
                            Primario incompleto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre3" value="Secundario incompleto" {{ old('maximo_nivel_educativo_padre') == 'Secundario incompleto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_padre3">
                            Secundario incompleto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre4" value="Secundario completo" {{ old('maximo_nivel_educativo_padre') == 'Secundario completo' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_padre4">
                            Secundario completo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre5" value="Superior no universitario incompleto" {{ old('maximo_nivel_educativo_padre') == 'Superior no universitario incompleto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_padre5">
                            Superior no universitario incompleto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre6" value="Superior no universitario completo" {{ old('maximo_nivel_educativo_padre') == 'Superior no universitario completo' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_padre6">
                            Superior no universitario completo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre7" value="Universitario incompleto" {{ old('maximo_nivel_educativo_padre') == 'Universitario incompleto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_padre7">
                            Universitario incompleto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre8" value="Universitario completo" {{ old('maximo_nivel_educativo_padre') == 'Universitario completo' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_padre8">
                            Universitario completo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre9" value="Desconozco ese dato" {{ old('maximo_nivel_educativo_padre') == 'Desconozco ese dato' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_padre9">
                            Desconozco ese dato
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Máximo nivel educativo alcanzado por la Madre</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre1" value="Analfabeto" {{ old('maximo_nivel_educativo_madre') == 'Analfabeto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_madre1">
                            Analfabeto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre2" value="Primario incompleto" {{ old('maximo_nivel_educativo_madre') == 'Primario incompleto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_madre2">
                            Primario incompleto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre3" value="Secundario incompleto" {{ old('maximo_nivel_educativo_madre') == 'Secundario incompleto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_madre3">
                            Secundario incompleto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre4" value="Secundario completo" {{ old('maximo_nivel_educativo_madre') == 'Secundario completo' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_madre4">
                            Secundario completo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre5" value="Superior no universitario incompleto" {{ old('maximo_nivel_educativo_madre') == 'Superior no universitario incompleto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_madre5">
                            Superior no universitario incompleto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre6" value="Superior no universitario completo" {{ old('maximo_nivel_educativo_madre') == 'Superior no universitario completo' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_madre6">
                            Superior no universitario completo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre7" value="Universitario incompleto" {{ old('maximo_nivel_educativo_madre') == 'Universitario incompleto' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_madre7">
                            Universitario incompleto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre8" value="Universitario completo" {{ old('maximo_nivel_educativo_madre') == 'Universitario completo' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_madre8">
                            Universitario completo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre9" value="Desconozco ese dato" {{ old('maximo_nivel_educativo_madre') == 'Desconozco ese dato' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maximo_nivel_educativo_madre9">
                            Desconozco ese dato
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>En cuanto a la situación de salud de tu grupo conviviente, poseen: Marca con una tilde lo que corresponde.</h4>
                    </label>
                    <div class="row col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">Jefe de Hogar</div>
                        <div class="col-md-3">Otro familiar conviviente</div>
                        <div class="col-md-4">Ninguno posee problema</div>
                    </div>
                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">Enfermedad</div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="familia_enfermedad[]" id="familia_enfermedad1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('familia_enfermedad', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="familia_enfermedad[]" id="familia_enfermedad2" value="Otro Familia Conviviente" {{ in_array('Otro Familia Conviviente', old('familia_enfermedad', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="familia_enfermedad[]" id="familia_enfermedad3" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('familia_enfermedad', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>


                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">Discapacidad</div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="familia_discapacidad[]" id="familia_discapacidad1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('familia_discapacidad', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="familia_discapacidad[]" id="familia_discapacidad2" value="Otro Familia Conviviente" {{ in_array('Otro Familia Conviviente', old('familia_discapacidad', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="familia_discapacidad[]" id="familia_discapacidad3" value="Ninguno Posee P" {{ in_array('Ninguno Posee P', old('familia_discapacidad', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>


                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">Obra Social</div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="familia_obra_social[]" id="familia_obra_social1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('familia_obra_social', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="familia_obra_social[]" id="familia_obra_social2" value="Otro Familia Conviviente" {{ in_array('Otro Familia Conviviente', old('familia_obra_social', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="familia_obra_social[]" id="familia_obra_social3" value="Ninguno Posee P" {{ in_array('Ninguno Posee P', old('familia_obra_social', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>En el último tiempo, ¿has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones?</h4>
                    </label>
                    <p><i>Marca con una tilde lo que corresponde.</i></p>
                    <div class="row col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">Jefe de Hogar</div>
                        <div class="col-md-2">Ingresante</div>
                        <div class="col-md-2">Otro conviviente</div>
                        <div class="col-md-3">No posee ningun problema</div>
                    </div>
                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Desalojo de la vivienda
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="desalojo_vivienda[]" id="desalojo_vivienda1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('desalojo_vivienda', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="desalojo_vivienda[]" id="desalojo_vivienda2" value="Ingresante" {{ in_array('Ingresante', old('desalojo_vivienda', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="desalojo_vivienda[]" id="desalojo_vivienda3" value="Otro conviviente" {{ in_array('Otro conviviente', old('desalojo_vivienda', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="desalojo_vivienda[]" id="desalojo_vivienda4" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('desalojo_vivienda', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Violencia intrafamiliar
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="violencia_intrafamiliar[]" id="violencia_intrafamiliar1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('violencia_intrafamiliar', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="violencia_intrafamiliar[]" id="violencia_intrafamiliar2" value="Ingresante" {{ in_array('Ingresante', old('violencia_intrafamiliar', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="violencia_intrafamiliar[]" id="violencia_intrafamiliar3" value="Otro conviviente" {{ in_array('Otro conviviente', old('violencia_intrafamiliar', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="violencia_intrafamiliar[]" id="violencia_intrafamiliar4" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('violencia_intrafamiliar', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Violencia de género
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="violencia_genero[]" id="violencia_genero1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('violencia_genero', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="violencia_genero[]" id="violencia_genero2" value="Ingresante" {{ in_array('Ingresante', old('violencia_genero', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="violencia_genero[]" id="violencia_genero3" value="Otro conviviente" {{ in_array('Otro conviviente', old('violencia_genero', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="violencia_genero[]" id="violencia_genero4" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('violencia_genero', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Fallecimiento de conviviente
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fallecimiento_conviviente[]" id="fallecimiento_conviviente1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('fallecimiento_conviviente', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fallecimiento_conviviente[]" id="fallecimiento_conviviente2" value="Ingresante" {{ in_array('Ingresante', old('fallecimiento_conviviente', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fallecimiento_conviviente[]" id="fallecimiento_conviviente3" value="Otro conviviente" {{ in_array('Otro conviviente', old('fallecimiento_conviviente', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fallecimiento_conviviente[]" id="fallecimiento_conviviente4" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('fallecimiento_conviviente', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Situaciones de consumo Problemático
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="situaciones_consumo[]" id="situaciones_consumo1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('situaciones_consumo', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="situaciones_consumo[]" id="situaciones_consumo2" value="Ingresante" {{ in_array('Ingresante', old('situaciones_consumo', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="situaciones_consumo[]" id="situaciones_consumo3" value="Otro conviviente" {{ in_array('Otro conviviente', old('situaciones_consumo', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="situaciones_consumo[]" id="situaciones_consumo4" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('situaciones_consumo', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Accidentes graves
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="accidentes_graves[]" id="accidentes_graves1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('accidentes_graves', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="accidentes_graves[]" id="accidentes_graves2" value="Ingresante" {{ in_array('Ingresante', old('accidentes_graves', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="accidentes_graves[]" id="accidentes_graves3" value="Otro conviviente" {{ in_array('Otro conviviente', old('accidentes_graves', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="accidentes_graves[]" id="accidentes_graves4" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('accidentes_graves', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Condenas extramuros
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="condenas_extramuros[]" id="condenas_extramuros1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('condenas_extramuros', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="condenas_extramuros[]" id="condenas_extramuros2" value="Ingresante" {{ in_array('Ingresante', old('condenas_extramuros', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="condenas_extramuros[]" id="condenas_extramuros3" value="Otro conviviente" {{ in_array('Otro conviviente', old('condenas_extramuros', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="condenas_extramuros[]" id="condenas_extramuros4" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('condenas_extramuros', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Embargo judicial al ingreso
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="embargo_judicial[]" id="embargo_judicial1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('embargo_judicial', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="embargo_judicial[]" id="embargo_judicial2" value="Ingresante" {{ in_array('Ingresante', old('embargo_judicial', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="embargo_judicial[]" id="embargo_judicial3" value="Otro conviviente" {{ in_array('Otro conviviente', old('embargo_judicial', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="embargo_judicial[]" id="embargo_judicial4" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('embargo_judicial', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Problemas judiciales
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="problemas_judiciales[]" id="problemas_judiciales1" value="Jefe de Hogar" {{ in_array('Jefe de Hogar', old('problemas_judiciales', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="problemas_judiciales[]" id="problemas_judiciales2" value="Ingresante" {{ in_array('Ingresante', old('problemas_judiciales', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="problemas_judiciales[]" id="problemas_judiciales3" value="Otro conviviente" {{ in_array('Otro conviviente', old('problemas_judiciales', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="problemas_judiciales[]" id="problemas_judiciales4" value="Ninguno Posee Problema" {{ in_array('Ninguno Posee Problema', old('problemas_judiciales', [])) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4> En tu vivienda contás con:</h4>
                    </label>
                    <div class="row col-md-12 text-center">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">Si</div>
                        <div class="col-md-2">No</div>
                    </div>
                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Agua potable
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="agua_potable" id="agua_potable1" value="Si" {{ old('agua_potable') == 'Si' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="agua_potable" id="agua_potable2" value="No" {{ old('agua_potable') == 'No' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>


                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Luz eléctrica
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="luz_electrica" id="luz_electrica1" value="Si" {{ old('luz_electrica') == 'Si' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="luz_electrica" id="luz_electrica2" value="No" {{ old('luz_electrica') == 'No' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>


                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Gas envasado
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gas_envasado" id="gas_envasado1" value="Si" {{ old('gas_envasado') == 'Si' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gas_envasado" id="gas_envasado2" value="No" {{ old('gas_envasado') == 'No' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>


                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Gas Natural
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gas_natural" id="gas_natural1" value="Si" {{ old('gas_natural') == 'Si' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gas_natural" id="gas_natural2" value="No" {{ old('gas_natural') == 'No' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Tenencia de la vivienda</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tenencia_vivienda" id="tenencia_vivienda1" value="Propia" {{ old('tenencia_vivienda') == 'Propia' ? 'checked' : '' }}>
                        <label class="form-check-label" for="tenencia_vivienda1">
                            Propia
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tenencia_vivienda" id="tenencia_vivienda2" value="Alquilada" {{ old('tenencia_vivienda') == 'Alquilada' ? 'checked' : '' }}>
                        <label class="form-check-label" for="tenencia_vivienda2">
                            Alquilada
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tenencia_vivienda" id="tenencia_vivienda3" value="Con Deuda" {{ old('tenencia_vivienda') == 'Con Deuda' ? 'checked' : '' }}>
                        <label class="form-check-label" for="tenencia_vivienda3">
                            Con Deuda
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tenencia_vivienda" id="tenencia_vivienda4" value="Cedida o Prestada" {{ old('tenencia_vivienda') == 'Cedida o Prestada' ? 'checked' : '' }}>
                        <label class="form-check-label" for="tenencia_vivienda4">
                            Cedida o Prestada
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4> El baño de la vivienda:</h4>
                    </label>
                    <div class="row col-md-12 text-center">
                        <div class="col-md-3"></div>
                        <div class="col-md-2">Si</div>
                        <div class="col-md-2">No</div>
                    </div>
                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Se encuentra dentro de la vivienda
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="baño_dentro" id="baño_dentro1" value="Si" {{ old('baño_dentro') == 'Si' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="baño_dentro" id="baño_dentro2" value="No" {{ old('baño_dentro') == 'No' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 text-center p-2">
                        <div class="col-md-3 text-left">
                            Tiene descarga de agua
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="baño_con_descarga" id="baño_con_descarga1" value="Si" {{ old('baño_con_descarga') == 'Si' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="baño_con_descarga" id="baño_con_descarga2" value="No" {{ old('baño_con_descarga') == 'No' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>El piso de la vivienda es de: </h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="piso_vivienda" id="piso_vivienda1" value="tierra" {{ old('piso_vivienda') == 'tierra' ? 'checked' : '' }}>
                        <label class="form-check-label" for="piso_vivienda1">
                            Tierra
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="piso_vivienda" id="piso_vivienda2" value="cemento" {{ old('piso_vivienda') == 'cemento' ? 'checked' : '' }}>
                        <label class="form-check-label" for="piso_vivienda2">
                            Cemento
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="piso_vivienda" id="piso_vivienda3" value="ceramico o similar" {{ old('piso_vivienda') == 'ceramico o similar' ? 'checked' : '' }}>
                        <label class="form-check-label" for="piso_vivienda3">
                            Cerámico o similar
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>La construcción de la vivienda es de: </h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="construccion_vivienda" id="construccion_vivienda1" value="adobe" {{ old('construccion_vivienda') == 'adobe' ? 'checked' : '' }}>
                        <label class="form-check-label" for="construccion_vivienda1">
                            Adobe
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="construccion_vivienda" id="construccion_vivienda2" value="ladrillo" {{ old('construccion_vivienda') == 'ladrillo' ? 'checked' : '' }}>
                        <label class="form-check-label" for="construccion_vivienda2">
                            Ladrillo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="construccion_vivienda" id="construccion_vivienda3" value="block" {{ old('construccion_vivienda') == 'block' ? 'checked' : '' }}>
                        <label class="form-check-label" for="construccion_vivienda3">
                            Block
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="construccion_vivienda" id="construccion_vivienda4" value="prefabricada" {{ old('construccion_vivienda') == 'prefabricada' ? 'checked' : '' }}>
                        <label class="form-check-label" for="construccion_vivienda4">
                            Prefabricada
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="construccion_vivienda" id="construccion_vivienda5" value="cartón o madera" {{ old('construccion_vivienda') == 'cartón o madera' ? 'checked' : '' }}>
                        <label class="form-check-label" for="construccion_vivienda5">
                            Cartón o madera
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    <label for="nombre_preferido" class="text-primary">
                        <h4>Condición general de la vivienda</h4>
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_vivienda" id="condicion_vivienda1" value="excelente" {{ old('condicion_vivienda') == 'excelente' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_vivienda1">
                            Excelente
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_vivienda" id="condicion_vivienda2" value="muy bueno" {{ old('condicion_vivienda') == 'muy bueno' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_vivienda2">
                            Muy Bueno
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_vivienda" id="condicion_vivienda3" value="bueno" {{ old('condicion_vivienda') == 'bueno' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_vivienda3">
                            Bueno
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_vivienda" id="condicion_vivienda4" value="regular" {{ old('condicion_vivienda') == 'regular' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_vivienda4">
                            Regular
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="condicion_vivienda" id="condicion_vivienda5" value="mala" {{ old('condicion_vivienda') == 'mala' ? 'checked' : '' }}>
                        <label class="form-check-label" for="condicion_vivienda5">
                            Mala
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <input type="submit" value="Siguiente" class="btn btn-primary col-md-12">
    </form>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/alumnos/encuesta_socioeconomica.js') }}"></script>
@endsection