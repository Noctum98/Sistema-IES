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

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Recibis:</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" name="subsidios[]" type="checkbox" value="PROGRESAR/ PRONAFE" id="subsidios1">
                    <label class="form-check-label" for="subsidios1">
                        PROGRESAR/ PRONAFE
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="subsidios[]" type="checkbox" value="medio boleto" id="subsidios2">
                    <label class="form-check-label" for="subsidios2">
                        Medio boleto estudiantil de Vías y Medios de transporte
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="subsidios[]" type="checkbox" value="beca municipal" id="subsidios3">
                    <label class="form-check-label" for="subsidios3">
                        Beca Municipal
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="subsidios[]" type="checkbox" value="beca de transporte" id="subsidios4">
                    <label class="form-check-label" for="subsidios4">
                        Beca de Transporte
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="subsidios[]" type="checkbox" value="beca de fotocopias" id="subsidios5">
                    <label class="form-check-label" for="subsidios5">
                        Beca de fotocopias
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="subsidios[]" type="checkbox" value="aporte por capacitación" id="subsidios6">
                    <label class="form-check-label" for="subsidios6">
                        Aporte por capacitación de parte de la empresa en la que trabajas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="subsidios[]" type="checkbox" value="IFE O Plan social" id="subsidios8">
                    <label class="form-check-label" for="subsidios8">
                        IFE O Plan social
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="subsidios[]" type="checkbox" value="no recibo Ninguna" id="subsidios9">
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
                <input type="file" class="form-control mt-2" id="comprobanete_progresar" name="comprobanete_progresar">
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
                    <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies1" value="menos de 1 Km.">
                    <label class="form-check-label" for="distancia_ies1">
                        Menos de 1 Km.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies2" value="desde 1,1 Km. a 3 Km.">
                    <label class="form-check-label" for="distancia_ies2">
                        Desde 1,1 Km. a 3 Km.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies3" value="desde 3,1 km a 7 km">
                    <label class="form-check-label" for="distancia_ies3">
                        Desde 3,1 km a 7 km
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies4" value="desde 7,1 a 15 Km.">
                    <label class="form-check-label" for="distancia_ies4">
                        Desde 7,1 a 15 Km.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies5" value="desde 15,1 Km. a  25 Km.">
                    <label class="form-check-label" for="distancia_ies5">
                        Desde 15,1 Km. a 25 Km.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies6" value="desde 25,1 Km. a 35 km.">
                    <label class="form-check-label" for="distancia_ies6">
                        Desde 25,1 Km. a 35 km.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies7" value="desde 35,1 Km. a 45 Km.">
                    <label class="form-check-label" for="distancia_ies7">
                        Desde 35,1 Km. a 45 Km.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="distancia_ies" id="distancia_ies8" value="más de 45,1 Km.">
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
                    <input class="form-check-input" name="subsidios[]" type="checkbox" value="colectivo" id="transporte_utilizado1">
                    <label class="form-check-label" for="transporte_utilizado1">
                        Colectivo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="auto propio" id="transporte_utilizado2">
                    <label class="form-check-label" for="transporte_utilizado2">
                        Auto propio
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="auto de otra persona" id="transporte_utilizado3">
                    <label class="form-check-label" for="transporte_utilizado3">
                        Auto de otra persona
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="caminando un trayecto mayor de 3 Km." id="transporte_utilizado3">
                    <label class="form-check-label" for="transporte_utilizado3">
                        Caminando un trayecto mayor de 3 Km.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="caminando un trayecto menor a 3 Km." id="transporte_utilizado4">
                    <label class="form-check-label" for="transporte_utilizado4">
                        Caminando un trayecto menor a 3 Km.
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="bicicleta" id="transporte_utilizado5">
                    <label class="form-check-label" for="transporte_utilizado5">
                        Bicicleta
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="transporte_utilizado[]" type="checkbox" value="moto" id="transporte_utilizado6">
                    <label class="form-check-label" for="transporte_utilizado6">
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
                    <h4>Si te has inscripto en PROGRESAR en el ciclo lectivo 2022, te pedimos que adjuntes comprobante</h4>
                </label>
                <input type="file" class="form-control mt-2" id="comprobanete_progresar" name="comprobanete_progresar">
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
                    <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes1" value="vivo solo">
                    <label class="form-check-label" for="cantidad_convivientes1">
                        Vivo solo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes2" value="de 1 a 2 personas">
                    <label class="form-check-label" for="cantidad_convivientes2">
                        De 1 a 2 personas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes3" value="de 3 a 4 personas">
                    <label class="form-check-label" for="cantidad_convivientes3">
                        De 3 a 4 personas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes4" value="de 5 a 6 personas">
                    <label class="form-check-label" for="cantidad_convivientes4">
                        De 5 a 6 personas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cantidad_convivientes" id="cantidad_convivientes5" value="más de 7 personas">
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
                    <input class="form-check-input" type="radio" name="cantidad_lugares_dormir" id="cantidad_lugares_dormir1" value="monoambiente">
                    <label class="form-check-label" for="cantidad_lugares_dormir1">
                        Mi vivienda es un monoambiente (No posee separado los espacios de comida y descanso)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cantidad_lugares_dormir" id="cantidad_lugares_dormir2" value="solo una habitacion">
                    <label class="form-check-label" for="cantidad_lugares_dormir2">
                        Posee solo una habitación exclusiva para dormir
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cantidad_lugares_dormir" id="cantidad_lugares_dormir3" value="dos habitaciones">
                    <label class="form-check-label" for="cantidad_lugares_dormir3">
                        Posee dos habitaciones para dormir
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cantidad_lugares_dormir" id="cantidad_lugares_dormir4" value="tres o mas habitaciones">
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
                    <input class="form-check-input" type="radio" name="ingresos_mensuales" id="ingresos_mensuales1" value="Menos de $50000">
                    <label class="form-check-label" for="ingresos_mensuales1">
                        Menos de $ 50000
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ingresos_mensuales" id="ingresos_mensuales2" value="Entre $50.0001 y $ 80.000">
                    <label class="form-check-label" for="ingresos_mensuales2">
                        Entre $50.0001 y $ 80.000
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ingresos_mensuales" id="ingresos_mensuales3" value="Entre $80.001 y 100.000">
                    <label class="form-check-label" for="ingresos_mensuales3">
                        Entre $80.001 y 100.000
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ingresos_mensuales" id="ingresos_mensuales3" value="Más de $ 100.001">
                    <label class="form-check-label" for="ingresos_mensuales3">
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
                    <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar1" value="Ocupada/o">
                    <label class="form-check-label" for="condicion_laboral_jefe_hogar1">
                        Ocupada/o
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar2" value="Independiente">
                    <label class="form-check-label" for="condicion_laboral_jefe_hogar2">
                        Independiente
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar3" value="Subocupada/o">
                    <label class="form-check-label" for="condicion_laboral_jefe_hogar3">
                        Subocupada/o
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar3" value="Desocupada/o">
                    <label class="form-check-label" for="condicion_laboral_jefe_hogar3">
                        Desocupada/o
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar4" value="Jubilada/o o Pensionada/o">
                    <label class="form-check-label" for="condicion_laboral_jefe_hogar4">
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
                    <h4>Máximo nivel educativo alcanzado por del Padre</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar1" value="Analfabeto">
                    <label class="form-check-label" for="condicion_laboral_jefe_hogar1">
                        Analfabeto
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="condicion_laboral_jefe_hogar" id="condicion_laboral_jefe_hogar2" value="Primario incompleto">
                    <label class="form-check-label" for="condicion_laboral_jefe_hogar2">
                        Primario incompleto
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre1" value="Secundario incompleto">
                    <label class="form-check-label" for="maximo_nivel_educativo_padre1">
                        Secundario incompleto
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre2" value="Secundario completo">
                    <label class="form-check-label" for="maximo_nivel_educativo_padre2">
                        Secundario completo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre3" value="Superior no universitario incompleto">
                    <label class="form-check-label" for="maximo_nivel_educativo_padre3">
                        Superior no universitario incompleto
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre3" value="Superior no universitario completo">
                    <label class="form-check-label" for="maximo_nivel_educativo_padre3">
                        Superior no universitario completo
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre4" value="Universitario incompleto">
                    <label class="form-check-label" for="maximo_nivel_educativo_padre4">
                        Universitario incompleto
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre5" value="Universitario completo">
                    <label class="form-check-label" for="maximo_nivel_educativo_padre5">
                        Universitario completo
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_padre" id="maximo_nivel_educativo_padre6" value="Desconozco ese dato">
                    <label class="form-check-label" for="maximo_nivel_educativo_padre6">
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
                    <h4>Máximo nivel educativo alcanzado por del Madre</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre1" value="Analfabeto">
                    <label class="form-check-label" for="maximo_nivel_educativo_madre1">
                        Analfabeto
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre2" value="Primario incompleto">
                    <label class="form-check-label" for="maximo_nivel_educativo_madre2">
                        Primario incompleto
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre3" value="Secundario incompleto">
                    <label class="form-check-label" for="maximo_nivel_educativo_madre3">
                        Secundario incompleto
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre4" value="Secundario completo">
                    <label class="form-check-label" for="maximo_nivel_educativo_madre4">
                        Secundario completo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre5" value="Superior no universitario incompleto">
                    <label class="form-check-label" for="maximo_nivel_educativo_madre5">
                        Superior no universitario incompleto
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre6" value="Superior no universitario completo">
                    <label class="form-check-label" for="maximo_nivel_educativo_madre6">
                        Superior no universitario completo
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre7" value="Universitario incompleto">
                    <label class="form-check-label" for="maximo_nivel_educativo_madre7">
                        Universitario incompleto
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre7" value="Universitario completo">
                    <label class="form-check-label" for="maximo_nivel_educativo_madre7">
                        Universitario completo
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="maximo_nivel_educativo_madre" id="maximo_nivel_educativo_madre8" value="Desconozco ese dato">
                    <label class="form-check-label" for="maximo_nivel_educativo_madre8">
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
                            <input class="form-check-input" type="checkbox" name="familia_enfermedad[]" id="familia_enfermedad1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="familia_enfermedad[]" id="familia_enfermedad2" value="Otro Familia Conviviente">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="familia_enfermedad[]" id="familia_enfermedad3" value="Ninguno Posee P">
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">Discapacidad</div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="familia_discapacidad[]" id="familia_discapacidad1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="familia_discapacidad[]" id="familia_discapacidad2" value="Otro Familia Conviviente">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="familia_discapacidad[]" id="familia_discapacidad3" value="Ninguno Posee P">
                        </div>
                    </div>
                </div>

                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">Obra Social</div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="familia_obra_social[]" id="familia_obra_social1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="familia_obra_social[]" id="familia_obra_social2" value="Otro Familia Conviviente">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="familia_obra_social[]" id="familia_obra_social3" value="Ninguno Posee P">
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
                            <input class="form-check-input" type="checkbox" name="desalojo_vivienda[]" id="desalojo_vivienda1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="desalojo_vivienda[]" id="desalojo_vivienda2" value="Ingresante">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="desalojo_vivienda[]" id="desalojo_vivienda3" value="Otro conviviente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="desalojo_vivienda[]" id="desalojo_vivienda4" value="Ninguno Posee Problema">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Violencia intrafamiliar
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_intrafamiliar[]" id="violencia_intrafamiliar1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_intrafamiliar[]" id="violencia_intrafamiliar2" value="Ingresante">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_intrafamiliar[]" id="violencia_intrafamiliar3" value="Otro conviviente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_intrafamiliar[]" id="violencia_intrafamiliar4" value="Ninguno Posee Problema">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Violencia de género
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_genero[]" id="violencia_genero1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_genero[]" id="violencia_genero2" value="Ingresante">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_genero[]" id="violencia_genero3" value="Otro conviviente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="violencia_genero[]" id="violencia_genero4" value="Ninguno Posee Problema">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Fallecimiento de conviviente
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fallecimiento_conviviente[]" id="fallecimiento_conviviente1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fallecimiento_conviviente[]" id="fallecimiento_conviviente2" value="Ingresante">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fallecimiento_conviviente[]" id="fallecimiento_conviviente3" value="Otro conviviente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fallecimiento_conviviente[]" id="fallecimiento_conviviente4" value="Ninguno Posee Problema">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Situaciones de consumo Problemático
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="situaciones_consumo[]" id="situaciones_consumo1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="situaciones_consumo[]" id="situaciones_consumo2" value="Ingresante">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="situaciones_consumo[]" id="situaciones_consumo3" value="Otro conviviente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="situaciones_consumo[]" id="situaciones_consumo4" value="Ninguno Posee Problema">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Accidentes graves
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="accidentes_graves[]" id="accidentes_graves1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="accidentes_graves[]" id="accidentes_graves2" value="Ingresante">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="accidentes_graves[]" id="accidentes_graves3" value="Otro conviviente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="accidentes_graves[]" id="accidentes_graves4" value="Ninguno Posee Problema">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Condenas extramuros
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="condenas_extramuros[]" id="condenas_extramuros1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="condenas_extramuros[]" id="condenas_extramuros2" value="Ingresante">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="condenas_extramuros[]" id="condenas_extramuros3" value="Otro conviviente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="condenas_extramuros[]" id="condenas_extramuros4" value="Ninguno Posee Problema">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Embargo judicial al ingreso
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="embargo_judicial[]" id="embargo_judicial1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="embargo_judicial[]" id="embargo_judicial2" value="Ingresante">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="embargo_judicial[]" id="embargo_judicial3" value="Otro conviviente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="embargo_judicial[]" id="embargo_judicial4" value="Ninguno Posee Problema">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Problemas judiciales
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="problemas_judiciales[]" id="problemas_judiciales1" value="Jefe de Hogar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="problemas_judiciales[]" id="problemas_judiciales2" value="Ingresante">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="problemas_judiciales[]" id="problemas_judiciales3" value="Otro conviviente">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="problemas_judiciales[]" id="problemas_judiciales4" value="Ninguno Posee Problema">
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
                            <input class="form-check-input" type="radio" name="agua_potable" id="agua_potable1" value="Si">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="agua_potable" id="agua_potable1" value="No">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Luz eléctrica
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="luz_electrica" id="luz_electrica1" value="Si">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="luz_electrica" id="luz_electrica2" value="No">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Gas envasado
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gas_envasado" id="gas_envasado" value="Si">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gas_envasado" id="gas_envasado" value="No">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                        Gas Natural
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gas_natural" id="gas_natural1" value="Si">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gas_natural" id="gas_natural2" value="No">
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
                    <input class="form-check-input" type="radio" name="tenencia_vivienda" id="tenencia_vivienda1" value="claro">
                    <label class="form-check-label" for="tenencia_vivienda1">
                        Propia
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tenencia_vivienda" id="tenencia_vivienda2" value="movistar">
                    <label class="form-check-label" for="tenencia_vivienda2">
                        Alquilada
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="tenencia_vivienda" id="tenencia_vivienda3" value="personal">
                    <label class="form-check-label" for="tenencia_vivienda3">
                        Con Deuda
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="tenencia_vivienda" id="tenencia_vivienda4" value="personal">
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
                            <input class="form-check-input" type="radio" name="baño_dentro" id="baño_dentro1" value="Si">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="baño_dentro" id="baño_dentro2" value="No">
                        </div>
                    </div>
                </div>
                <div class="row col-md-12 text-center p-2">
                    <div class="col-md-3 text-left">
                    Tiene descarga de agua
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="baño_con_descarga" id="baño_con_descarga1" value="Si">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="baño_con_descarga" id="baño_con_descarga2" value="No">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection