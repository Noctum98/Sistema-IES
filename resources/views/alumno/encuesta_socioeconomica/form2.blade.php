@extends('layouts.app-prueba')
@section('content')
<div class="container col-md-8 p-3">
    <div class="card text-white bg-primary mb-3">
        <div class="card-header">
            <h2>{{$carrera->sede->nombre.' - '.$carrera->nombre}} - Encuesta Socioeconómica y Motivacional {{ date('Y') }}</h2>
        </div>
        <div class="card-body">
            <p>Queremos ahora conocer más sobre tu trayectoria educativa en el nivel secundario, tus motivaciones, expectativas y aquellos factores que de alguna manera puedan interferir en el cursado regular de la carrera que has elegido.</p>
            <p>Si disponemos de esta información de manera veraz, podremos ofrecerte un mejor acompañamiento.</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Motivos que te animan a seguir estudiando:</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar1" value="superación personal" {{ old('motivo_para_estudiar') === 'superación personal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar1">
                        Superación personal
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar2" value="mejorar las condiciones del trabajo que poseo" {{ old('motivo_para_estudiar') === 'mejorar las condiciones del trabajo que poseo' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar2">
                        Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar3" value="tener mayor acceso laboral" {{ old('motivo_para_estudiar') === 'tener mayor acceso laboral' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar3">motivo_para_estudiar
                        Tener mayor acceso laboral
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar6" value="cercanía con mi domicilio" {{ old('motivo_para_estudiar') === 'cercanía con mi domicilio' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar6">
                        Cercanía con mi domicilio
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar4" value="porque me gusta la carrera" {{ old('motivo_para_estudiar') === 'porque me gusta la carrera' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar4">
                        Mejorar las condiciones del trabajo que poseo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="motivo_para_estudiar" id="motivo_para_estudiar5" value="otro" {{ old('motivo_para_estudiar') === 'otro' ? 'checked' : '' }}>
                    <label class="form-check-label" for="motivo_para_estudiar5">
                        Otros
                    </label>
                </div>
                <div class="form-group d-none" id="otra_identidad_genero">
                    <label for="motivo_para_estudiar_otro">Cual?</label>
                    <input type="text" class="form-control mt-2" id="motivo_para_estudiar_otro" name="motivo_para_estudiar_otro" value="{{ old('motivo_para_estudiar_otro') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Cómo conociste el instituto?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto1" value="por otra persona" {{ old('conocimiento_instituto') === 'por otra persona' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto1">
                        Por otra persona
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto2" value="por Facebook" {{ old('conocimiento_instituto') === 'por Facebook' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto2">
                        Por Facebook
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto3" value="por Instagram" {{ old('conocimiento_instituto') === 'por Instagram' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto3">
                        Por Instagram
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto4" value="por la TV" {{ old('conocimiento_instituto') === 'por la TV' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto4">
                        Por la TV
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto5" value="por la página Web del IES" {{ old('conocimiento_instituto') === 'por la página Web del IES' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto5">
                        Por la página Web del IES
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto6" value="por la radio" {{ old('conocimiento_instituto') === 'por la radio' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto6">
                        Por la radio
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto7" value="en la oferta educativa" {{ old('conocimiento_instituto') === 'en la oferta educativa' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto7">
                        En la oferta educativa
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto8" value="en el Instituto abierto" {{ old('conocimiento_instituto') === 'en el Instituto abierto' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto8">
                        En el Instituto abierto
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto9" value="lo conoces porque sos de la zona" {{ old('conocimiento_instituto') === 'lo conoces porque sos de la zona' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto9">
                        Lo conoces porque sos de la zona
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto11" value="fuimos a tu escuela" {{ old('conocimiento_instituto') === 'fuimos a tu escuela' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto11">
                        Fuimos a tu escuela
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="conocimiento_instituto" id="conocimiento_instituto10" value="otro" {{ old('conocimiento_instituto') === 'otro' ? 'checked' : '' }}>
                    <label class="form-check-label" for="conocimiento_instituto10">
                        Otros
                    </label>
                </div>
                <div class="form-group d-none" id="otra_identidad_genero">
                    <label for="motivo_para_estudiar_otro">Cual?</label>
                    <input type="text" class="form-control mt-2" id="conocimiento_instituto_otro" name="conocimiento_instituto_otro" value="{{ old('conocimiento_instituto_otro') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Estás completamente seguro/a de la carrera elegida?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="seguridad_carrera" id="seguridad_carrera1" value="si" {{ old('seguridad_carrera') === 'si' ? 'checked' : '' }}>
                    <label class="form-check-label" for="seguridad_carrera1">
                        Si
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="seguridad_carrera" id="seguridad_carrera2" value="no" {{ old('seguridad_carrera') === 'no' ? 'checked' : '' }}>
                    <label class="form-check-label" for="seguridad_carrera2">
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
                    <h4>Según lo que respondiste en la pregunta anterior, fundamentá tu respuesta:</h4>
                </label>
                <input type="text" class="form-control mt-2" id="fundamento_seguridad" name="fundamento_seguridad" value="{{ old('fundamento_seguridad') }}" required>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Estás completamente seguro/a de la carrera elegida?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="como_ingresa" id="como_ingresa1" value="Finalizado el nivel medio" {{ old('como_ingresa') === 'Finalizado el nivel medio' ? 'checked' : '' }}>
                    <label class="form-check-label" for="como_ingresa1">
                        Finalizado el nivel medio
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="como_ingresa" id="como_ingresa2" value="Adeudando materias" {{ old('como_ingresa') === 'Adeudando materias' ? 'checked' : '' }}>
                    <label class="form-check-label" for="como_ingresa2">
                        Adeudando materias
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="como_ingresa" id="como_ingresa3" value="Ingreso por Artículo 7°" {{ old('como_ingresa') === 'Ingreso por Artículo 7°' ? 'checked' : '' }}>
                    <label class="form-check-label" for="como_ingresa3">
                        Ingreso por Artículo 7°
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="como_ingresa" id="como_ingresa4" value="Empezado pero no concluido una carrera de nivel superior" {{ old('como_ingresa') === 'Empezado pero no concluido una carrera de nivel superior' ? 'checked' : '' }}>
                    <label class="form-check-label" for="como_ingresa4">
                        Empezado pero no concluido una carrera de nivel superior
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="como_ingresa" id="como_ingresa5" value="Concluído una carrera de nivel superior" {{ old('como_ingresa') === 'Concluído una carrera de nivel superior' ? 'checked' : '' }}>
                    <label class="form-check-label" for="como_ingresa5">
                        Concluído una carrera de nivel superior
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="como_ingresa" id="como_ingresa6" value="otro" {{ old('como_ingresa') === 'otro' ? 'checked' : '' }}>
                    <label class="form-check-label" for="como_ingresa6">
                        Otro
                    </label>
                </div>
                <div class="form-group d-none" id="otra_identidad_genero">
                    <label for="motivo_para_estudiar_otro">Cual?</label>
                    <input type="text" class="form-control mt-2" id="como_ingresa_otro" name="como_ingresa_otro" value="{{ old('como_ingresa_otro') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Con respecto a los estudios de Nivel Medio, menciona donde los realizaste</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_nivel_medio" id="tipo_nivel_medio1" value="Secundaria Orientada (5años)" {{ old('tipo_nivel_medio') === 'Secundaria Orientada (5años)' ? 'checked' : '' }}>
                    <label class="form-check-label" for="tipo_nivel_medio1">
                        Secundaria Orientada (5años)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_nivel_medio" id="tipo_nivel_medio2" value="Secundaria en escuela Técnica (6 años)" {{ old('tipo_nivel_medio') === 'Secundaria en escuela Técnica (6 años)' ? 'checked' : '' }}>
                    <label class="form-check-label" for="tipo_nivel_medio2">
                        Secundaria en escuela Técnica (6 años)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_nivel_medio" id="tipo_nivel_medio3" value="CENS" {{ old('tipo_nivel_medio') === 'CENS' ? 'checked' : '' }}>
                    <label class="form-check-label" for="tipo_nivel_medio3">
                        CENS
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_nivel_medio" id="tipo_nivel_medio4" value="INGRESA POR ART.7MO" {{ old('tipo_nivel_medio') === 'INGRESA POR ART.7MO' ? 'checked' : '' }}>
                    <label class="form-check-label" for="tipo_nivel_medio4">
                        INGRESA POR ART.7MO
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="materia_menos_costosa" class="text-primary">
                    <h4>Menciona la materia que menos te ha costado en la escuela:</h4>
                </label>
                <input type="text" class="form-control mt-2" id="materia_menos_costosa" name="materia_menos_costosa" value="{{ old('materia_menos_costosa') }}" required>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="materia_mas_costosa" class="text-primary">
                    <h4>Menciona la materia que mas te ha costado en la escuela:</h4>
                </label>
                <input type="text" class="form-control mt-2" id="materia_mas_costosa" name="materia_mas_costosa" value="{{ old('materia_mas_costosa') }}" required>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿Considerás que necesitas ayuda para estudiar?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ayuda_para_estudiar" id="ayuda_para_estudiar1" value="si" {{ old('ayuda_para_estudiar') === 'si' ? 'checked' : '' }}>
                    <label class="form-check-label" for="ayuda_para_estudiar1">
                        Si
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ayuda_para_estudiar" id="ayuda_para_estudiar2" value="no" {{ old('ayuda_para_estudiar') === 'no' ? 'checked' : '' }}>
                    <label class="form-check-label" for="ayuda_para_estudiar2">
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
                    <h4>¿Considerás que necesitas ayuda para estudiar?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="horas_estudio" id="horas_estudio2" value="Menos de 1 hora" {{ old('horas_estudio') === 'Menos de 1 hora' ? 'checked' : '' }}>
                    <label class="form-check-label" for="horas_estudio2">
                        Menos de 1 hora
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="horas_estudio" id="horas_estudio1" value="Entre 1 y 2 horas" {{ old('horas_estudio') === 'Entre 1 y 2 horas' ? 'checked' : '' }}>
                    <label class="form-check-label" for="horas_estudio1">
                        Entre 1 y 2 horas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="horas_estudio" id="horas_estudio3" value="Entre 3 y 4 horas" {{ old('horas_estudio') === 'Entre 3 y 4 horas' ? 'checked' : '' }}>
                    <label class="form-check-label" for="horas_estudio3">
                        Entre 3 y 4 horas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="horas_estudio" id="horas_estudio4" value="Mas de 4 horas" {{ old('horas_estudio') === 'Mas de 4 horas' ? 'checked' : '' }}>
                    <label class="form-check-label" for="horas_estudio4">
                        Mas de 4 horas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="horas_estudio" id="horas_estudio5" value="No le dedico ninguna hora" {{ old('horas_estudio') === 'No le dedico ninguna hora' ? 'checked' : '' }}>
                    <label class="form-check-label" for="horas_estudio5">
                        No le dedico ninguna hora
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>Considerás que podrías tener dificultades para continuar los estudios por las siguientes razones:</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="Situación económica" id="dificultad_estudio1" {{ in_array('Situación económica', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio1">
                        Situación económica
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="Acceso al transporte" id="dificultad_estudio2" {{ in_array('Acceso al transporte', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio2">
                        Acceso al transporte
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="si" id="dificultad_estudio3" {{ in_array('Superposición horaria con el trabajo', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio3">
                        Superposición horaria con el trabajo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="Cuidado de familiar" id="dificultad_estudio4" {{ in_array('Cuidado de familiar', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio4">
                        Cuidado de familiar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="Enfermedad/Discapacidad" id="dificultad_estudio5" {{ in_array('Enfermedad/Discapacidad', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio5">
                        Enfermedad/Discapacidad
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="Acceso al material de trabajo" id="dificultad_estudio6" {{ in_array('Acceso al material de trabajo', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio6">
                        Acceso al material de trabajo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="Acceso a conectividad" id="dificultad_estudio7" {{ in_array('Acceso a conectividad', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio7">
                        Acceso a conectividad
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="No contar con herramientas informáticas" id="dificultad_estudio8" {{ in_array('No contar con herramientas informáticas', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio8">
                        No contar con herramientas informáticas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="No contar con un espacio cómodo y tranquilo para estudiar" id="dificultad_estudio9" {{ in_array('No contar con un espacio cómodo y tranquilo para estudiar', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio9">
                        No contar con un espacio cómodo y tranquilo para estudiar
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="dificultad_estudio[]" type="checkbox" value="otro" id="dificultad_estudio10" {{ in_array('otro', old('dificultad_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="dificultad_estudio10">
                        Otro
                    </label>
                </div>
                <div class="form-group d-none" id="otra_identidad_genero">
                    <label for="dificultad_estudio_otro">Cual?</label>
                    <input type="text" class="form-control mt-2" id="dificultad_estudio_otro" name="dificultad_estudio_otro" value="{{ old('dificultad_estudio_otro') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>En cuanto a tu modalidad de estudio/aprendizaje, te pedimos que menciones tus herramientas de estudio</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_estudio[]" type="checkbox" value="Elaboración de resúmenes" id="herramientas_estudio1" {{ in_array('Elaboración de resúmenes', old('herramientas_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="herramientas_estudio1">
                        Elaboración de resúmenes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_estudio[]" type="checkbox" value="Elaboración de mapas conceptuales y/o mapas mentales" id="herramientas_estudio2" {{ in_array('Elaboración de mapas conceptuales y/o mapas mentales', old('herramientas_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="herramientas_estudio2">
                        Elaboración de mapas conceptuales y/o mapas mentales
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_estudio[]" type="checkbox" value="Solo lectura del material bibliográfico y apuntes de clase" id="herramientas_estudio3" {{ in_array('Solo lectura del material bibliográfico y apuntes de clase', old('herramientas_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="herramientas_estudio3">
                        Solo lectura del material bibliográfico y apuntes de clase
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_estudio[]" type="checkbox" value="Utilización de material de apoyo visual y/o auditivo" id="herramientas_estudio3" {{ in_array('Utilización de material de apoyo visual y/o auditivo', old('herramientas_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="herramientas_estudio3">
                        Utilización de material de apoyo visual y/o auditivo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_estudio[]" type="checkbox" value="Estudio y repaso solo" id="herramientas_estudio4" {{ in_array('Estudio y repaso solo', old('herramientas_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="herramientas_estudio4">
                        Estudio y repaso solo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="herramientas_estudio[]" type="checkbox" value="Estudio y repaso en compañía de otra/otras perosonas" id="herramientas_estudio5" {{ in_array('Estudio y repaso en compañía de otra/otras perosonas', old('herramientas_estudio', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="herramientas_estudio5">
                        Estudio y repaso en compañía de otra/otras perosonas
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="form-group">
                <label for="nombre_preferido" class="text-primary">
                    <h4>¿En qué lugar te gustaría trabajar?</h4>
                </label>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Hospital" id="lugar_trabajo1" {{ in_array('Hospital', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo1">
                        Hospital
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Medios de comunicación" id="lugar_trabajo2" {{ in_array('Medios de comunicación', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo2">
                        Medios de comunicación
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Bodegas" id="lugar_trabajo3" {{ in_array('Bodegas', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo3">
                        Bodegas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Fábricas" id="lugar_trabajo4" {{ in_array('Fábricas', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo4">
                        Fábricas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Empresas" id="lugar_trabajo5" {{ in_array('Empresas', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo5">
                        Empresas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Municipio" id="lugar_trabajo6" {{ in_array('Municipio', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo6">
                        Municipio
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Laboratorios" id="lugar_trabajo7" {{ in_array('Laboratorios', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo7">
                        Laboratorios
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Finca" id="lugar_trabajo8" {{ in_array('Finca', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo8">
                        Finca
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Organismos estatales" id="lugar_trabajo9" {{ in_array('Organismos estatales', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo9">
                        Organismos estatales
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Organismos privados" id="lugar_trabajo10" {{ in_array('Organismos privados', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo10">
                        Organismos privados
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="Emprendimientos" id="lugar_trabajo11" {{ in_array('Emprendimientos', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo11">
                        Emprendimientos
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="lugar_trabajo[]" type="checkbox" value="otro" id="lugar_trabajo12" {{ in_array('otro', old('lugar_trabajo', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="lugar_trabajo12">
                        Otro
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection