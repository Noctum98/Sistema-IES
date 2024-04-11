<?php

namespace App\Services\Alumno;

use App\Models\Alumno;
use App\Models\Alumno\EncuestaSocioeconomica;
use App\Models\Materia;
use App\Models\Proceso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EncuestaSocioeconomicaService
{
    public static $questions = [
        'Identidad de género' => 'identidad_genero',
        'Edades' => 'edad_encuesta',
        'Empresa de Teléfono' => 'empresa_telefono',
        'Accesso a Internet' => 'acceso_internet',
        'Herramientas Tecnológicas' => 'herramientas_tecnologicas',
        '¿Durante el ciclo lectivo anterior estuviste vinculado/a a alguna actividad educativa de manera virtual?' => 'vinculacion_ciclo',
        'Condición laboral del/de la estudiante' => 'condicion_laboral',
        '¿Tu trabajo está relacionado con la carrera en la que te has inscripto/que estás cursando?' => 'trabajo_relacionado',
        '¿Sos jefe/a de hogar?' => 'jefe_hogar',
        '¿Tenés hijos/as a cargo?' => 'hijos_a_cargo',
        'Edad de tus hijos' => 'edad_hijos',
        'En cuanto a tu situación de salud, declaras poseer'=>'situacion_salud',
        'CUD'=>'cud',
        'Obra Social' => 'obra_social',
        'En el presente ciclo lectivo recibís o has gestionado' => 'subsidios',
        'Kilómetros de distancia desde tu domicilio hasta el IES' => 'distancia_ies',
        'Transporte utilizado para concurrir al IES'=>'transporte_utilizado',
        'Cantidad de personas que conviven con vos' => 'cantidad_convivientes',
        'Cantidad de lugares para dormir que posee tu vivienda' => 'cantidad_lugares_dormir',
        'Ingresos mensuales del grupo familiar'=>'ingresos_mensuales',
        'Condición laboral del Jefe/a de hogar' => 'condicion_laboral_jefe_hogar',
        'Máximo nivel educativo alcanzado por el Padre' => 'maximo_nivel_educativo_padre',
        'Máximo nivel educativo alcanzado por la Madre' => 'maximo_nivel_educativo_madre',
        'En cuanto a la situación de salud de tu grupo conviviente, poseen: Enfermedad' => 'familia_enfermedad',
        'En cuanto a la situación de salud de tu grupo conviviente, poseen: Discapacidad' => 'familia_discapacidad',
        'En cuanto a la situación de salud de tu grupo conviviente, poseen: Obra Social' => 'familia_obra_social',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Desalojo' => 'desalojo_vivienda',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Violencia Intrafamiliar' => 'violencia_intrafamiliar',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Violencia Género' => 'violencia_genero',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Fallecimiento Conviviente' => 'fallecimiento_conviviente',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Situaciones de consumo Problemático' => 'situaciones_consumo',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Accidentes graves' => 'accidentes_graves',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Condenas extramuros' => 'condenas_extramuros',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Embargo judicial al ingreso' => 'embargo_judicial',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Problemas judiciales' => 'problemas_judiciales',
        '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Problemas de salud mental' => 'problemas_salud_mental',
        'En tu vivienda contás con:Agua Potable' => 'agua_potable',
        'En tu vivienda contás con:Luz Electrica' => 'luz_electrica',
        'En tu vivienda contás con:Gas Envasado' => 'gas_envasado',
        'En tu vivienda contás con:Gas Natural' => 'gas_natural',
        'Tenencia de la vivienda' => 'tenencia_vivienda',
        'El baño de la vivienda: Dentro de la vivienda' => 'baño_dentro',
        'El baño de la vivienda: Con Descarga de agua' => 'baño_con_descarga',
        'Piso de la vivienda es de:' => 'piso_vivienda',
        'La construcción de la vivienda es de:' => 'construccion_vivienda',
        'Condición general de la vivienda' => 'condicion_vivienda',
    ];

    public static $questions_motivacionales = [
        'Motivos que te animan a seguir estudiando:' => 'motivo_para_estudiar',
        '¿Cómo conociste el instituto?' => 'conocimiento_instituto',
        '¿Estás completamente seguro/a de la carrera elegida?' => 'seguridad_carrera',
        'Ingresas al IES habiendo:' => 'como_ingresa',
        'Con respecto a los estudios de Nivel Medio, menciona donde los realizaste' => 'tipo_nivel_medio',
        '¿Considerás que necesitas ayuda para estudiar?' => 'ayuda_para_estudiar',
        '¿Cuánto tiempo le dedicas al estudio?' => 'horas_estudio',
        'Considerás que podrías tener dificultades para continuar los estudios por las siguientes razones:' => 'dificultad_estudio',
        'Herramientas de estudio' => 'herramientas_estudio',
        '¿En qué lugar te gustaría trabajar?' => 'lugar_trabajo',
        '¿Realizás actividades extras a la carrera? especificá si es así' => 'actividades_extras',
        '¿Te gustaría hacer alguna? especificá si es así' => 'desc_actividades_extras',
        '¿En qué horario podrías realizar estas actividades?' => 'horario_actividades',
    ];

    public function procesarDatos($request)
    {
        $acceso_internet = '';
        foreach ($request['acceso_internet'] as $acceso) {
            $acceso_internet = $acceso_internet . '|' . $acceso;
        }

        $request['acceso_internet'] = $acceso_internet;


        $herramientas_tecnologicas = '';
        foreach ($request['herramientas_tecnologicas'] as $herramientas) {
            $herramientas_tecnologicas = $herramientas_tecnologicas . '|' . $herramientas;
        }

        $request['herramientas_tecnologicas'] = $herramientas_tecnologicas;

        $edad_hijos = '';
        foreach ($request['edad_hijos'] as $edad) {
            $edad_hijos = $edad_hijos . '|' . $edad;
        }

        $request['edad_hijos'] = $edad_hijos;

        $situacion_salud = '';
        foreach ($request['situacion_salud'] as $situacion) {
            $situacion_salud = $situacion_salud . '|' . $situacion;
        }

        $request['situacion_salud'] = $situacion_salud;

        $problemas_salud_mental = '';
        foreach ($request['problemas_salud_mental'] as $problema) {
            $problemas_salud_mental = $problemas_salud_mental . '|' . $problema;
        }

        $request['problemas_salud_mental'] = $problemas_salud_mental;

        $subsidios = '';
        foreach ($request['subsidios'] as $subsidio) {
            $subsidios = $subsidios . '|' . $subsidio;
        }
        $request['subsidios'] = $subsidios;

        $transporte_utilizado = '';
        foreach ($request['transporte_utilizado'] as $transporte) {
            $transporte_utilizado = $transporte_utilizado . '|' . $transporte;
        }
        $request['transporte_utilizado'] = $transporte_utilizado;

        $familia_enfermedad = '';
        foreach ($request['familia_enfermedad'] as $fenfermedad) {
            $familia_enfermedad = $familia_enfermedad . '|' . $fenfermedad;
        }
        $request['familia_enfermedad'] = $familia_enfermedad;

        $familia_discapacidad = '';
        foreach ($request['familia_discapacidad'] as $fdiscapacidad) {
            $familia_discapacidad = $familia_discapacidad . '|' . $fdiscapacidad;
        }
        $request['familia_discapacidad'] = $familia_discapacidad;

        $familia_obra_social = '';
        foreach ($request['familia_obra_social'] as $fobrasocial) {
            $familia_obra_social = $familia_obra_social . '|' . $fobrasocial;
        }
        $request['familia_obra_social'] = $familia_obra_social;

        $desalojo_vivienda = '';
        foreach ($request['desalojo_vivienda'] as $desalojo) {
            $desalojo_vivienda = $desalojo_vivienda . '|' . $desalojo;
        }
        $request['desalojo_vivienda'] = $desalojo_vivienda;

        $violencia_intrafamiliar = '';
        foreach ($request['violencia_intrafamiliar'] as $violencia) {
            $violencia_intrafamiliar = $violencia_intrafamiliar . '|' . $violencia;
        }
        $request['violencia_intrafamiliar'] = $violencia_intrafamiliar;


        $violencia_genero = '';
        foreach ($request['violencia_genero'] as $vgenero) {
            $violencia_genero = $violencia_genero . '|' . $vgenero;
        }
        $request['violencia_genero'] = $violencia_genero;

        $fallecimiento_conviviente = '';
        foreach ($request['fallecimiento_conviviente'] as $fconviviente) {
            $fallecimiento_conviviente = $fallecimiento_conviviente . '|' . $fconviviente;
        }
        $request['fallecimiento_conviviente'] = $fallecimiento_conviviente;

        $situaciones_consumo = '';
        foreach ($request['situaciones_consumo'] as $situaciones) {
            $situaciones_consumo = $situaciones_consumo . '|' . $situaciones;
        }
        $request['situaciones_consumo'] = $situaciones_consumo;

        $accidentes_graves = '';
        foreach ($request['accidentes_graves'] as $accidentes) {
            $accidentes_graves = $accidentes_graves . '|' . $accidentes;
        }
        $request['accidentes_graves'] = $accidentes_graves;

        $condenas_extramuros = '';
        foreach ($request['condenas_extramuros'] as $cextramuros) {
            $condenas_extramuros = $condenas_extramuros . '|' . $cextramuros;
        }
        $request['condenas_extramuros'] = $condenas_extramuros;

        $embargo_judicial = '';
        foreach ($request['embargo_judicial'] as $ejudicial) {
            $embargo_judicial = $embargo_judicial . '|' . $ejudicial;
        }
        $request['embargo_judicial'] = $embargo_judicial;

        $problemas_judiciales = '';
        foreach ($request['problemas_judiciales'] as $pjudicial) {
            $problemas_judiciales = $problemas_judiciales . '|' . $pjudicial;
        }
        $request['problemas_judiciales'] = $problemas_judiciales;

        return $request;
    }

    public function procesarDatos2($request)
    {
        if ($request['motivo_para_estudiar_otro']) {
            $request['motivo_para_estudiar'] = $request['motivo_para_estudiar'] . '|' . $request['motivo_para_estudiar_otro'];
        }

        if ($request['conocimiento_instituto_otro']) {
            $request['conocimiento_instituto'] = $request['conocimiento_instituto'] . '|' . $request['conocimiento_instituto_otro'];
        }

        if ($request['como_ingresa_otro']) {
            $request['como_ingresa'] = $request['como_ingresa'] . '|' . $request['como_ingresa_otro'];
        }

        if ($request['desc_actividades_extras_otro']) {
            $request['desc_actividades_extras'] = $request['desc_actividades_extras'] . '|' . $request['desc_actividades_extras_otro'];
        }

        if ($request['dificultad_estudio']) {
            $dificultad_estudio = '';
            foreach ($request['dificultad_estudio'] as $dificultad) {
                $dificultad_estudio = $dificultad_estudio . '|' . $dificultad;
            }

            $request['dificultad_estudio'] = $dificultad_estudio;
        }

        if ($request['herramientas_estudio']) {
            $herramientas_estudio = '';
            foreach ($request['herramientas_estudio'] as $herramienta) {
                $herramientas_estudio = $herramientas_estudio . '|' . $herramienta;
            }

            $request['herramientas_estudio'] = $herramientas_estudio;
        }

        if ($request['lugar_trabajo']) {
            $lugar_trabajo = '';
            foreach ($request['lugar_trabajo'] as $lugar) {
                $lugar_trabajo = $lugar_trabajo . '|' . $lugar;
            }

            $request['lugar_trabajo'] = $lugar_trabajo;
        }

        if ($request['horario_actividades']) {
            $horario_actividades = '';
            foreach ($request['horario_actividades'] as $horario) {
                $horario_actividades = $horario_actividades . '|' . $horario;
            }

            $request['horario_actividades'] = $horario_actividades;
        }

        return $request;
    }

    public function formatearDatos($encuestas)
    {
        $datos = [];

        $opciones = [
            'identidad_genero' => ['MASCULINO', 'FEMENINO', 'TRANSGÉNERO', 'OTRO'],
            'empresa_telefono' => ['CLARO', 'MOVISTAR', 'PERSONAL', 'TWENTI', 'OTRA'],
            'edad_encuesta' => ['18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', 'MÁS DE 30', 'MENOS DE 18'],
            'condicion_laboral' => ['OCUPADA/O', 'INDEPENDIENTE', 'SUBOCUPADA/O', 'DESOCUPADA/O', 'SOLO ESTUDIO'],
            'vinculacion_ciclo' => ['SI', 'NO'],
            'jefe_hogar' => ['SI', 'NO'],
            'hijos_a_cargo' => ['SI', 'NO'],
            'trabajo_relacionado' => ['SI', 'NO', 'PARCIALMENTE', 'NO TRABAJO'],
            'cud' => ['SI', 'NO'],
            'obra_social' => ['SI', 'NO'],
            'distancia_ies' => ['MENOS DE 1KM.', 'DESDE 1,1 KM. A 3 KM.', 'DESDE 3,1 KM A 7 KM', 'DESDE 7,1 A 15 KM.', 'DESDE 15,1 KM. A  25 KM.', 'DESDE 25,1 KM. A 35 KM.', 'DESDE 35,1 KM. A 45 KM.', 'MÁS DE 45,1 KM.'],
            'cantidad_convivientes' => ['VIVO SOLO', 'DE 1 A 2 PERSONAS', 'DE 3 A 4 PERSONAS', 'DE 5 A 6 PERSONAS', 'MÁS DE 7 PERSONAS'],
            'cantidad_lugares_dormir' => ['MONOAMBIENTE', 'SOLO UNA HABITACION', 'DOS HABITACIONES', 'TRES O MAS HABITACIONES'],
            'ingresos_mensuales' => ['MENOS DE $200.000', 'ENTRE ENTRE $200.0001 Y $300.000', 'ENTRE $300.001 Y $400.000', 'MÁS DE $ 400.001'],
            'condicion_laboral_jefe_hogar' => ['OCUPADA/O', 'INDEPENDIENTE', 'SUBOCUPADA/O', 'DESOCUPADA/O', 'JUBILADA/O O PENSIONADA/O'],
            'maximo_nivel_educativo_padre' => ['ANALFABETO', 'PRIMARIO COMPLETO', 'PRIMARIO INCOMPLETO', 'SECUNDARIO INCOMPLETO', 'SECUNDARIO COMPLETO', 'SUPERIOR NO UNIVERSITARIO INCOMPLETO', 'SUPERIOR NO UNIVERSITARIO COMPLETO', 'UNIVERSITARIO INCOMPLETO', 'UNIVERSITARIO COMPLETO', 'DESCONOZCO ESE DATO'],
            'maximo_nivel_educativo_madre' => ['ANALFABETO', 'PRIMARIO COMPLETO', 'PRIMARIO INCOMPLETO', 'SECUNDARIO INCOMPLETO', 'SECUNDARIO COMPLETO', 'SUPERIOR NO UNIVERSITARIO INCOMPLETO', 'SUPERIOR NO UNIVERSITARIO COMPLETO', 'UNIVERSITARIO INCOMPLETO', 'UNIVERSITARIO COMPLETO', 'DESCONOZCO ESE DATO'],
            'agua_potable' => ['SI', 'NO'],
            'luz_electrica' => ['SI', 'NO'],
            'gas_envasado' => ['SI', 'NO'],
            'gas_natural' => ['SI', 'NO'],
            'tenencia_vivienda' => ['PROPIA', 'ALQUILADA', 'CON DEUDA', 'CEDIDA O PRESTADA'],
            'baño_dentro' => ['SI', 'NO'],
            'baño_con_descarga' => ['SI', 'NO'],
            'piso_vivienda' => ['TIERRA', 'CEMENTO', 'CERAMICO O SIMILAR'],
            'construccion_vivienda' => ['ADOBE', 'LADRILLO', 'BLOCK', 'PREFABRICADA', 'CARTÓN O MADERA'],
            'condicion_vivienda' => ['EXCELENTE', 'MUY BUENO', 'BUENO', 'REGULAR', 'MALA'],
            'motivo_para_estudiar' => ['SUPERACIÓN PERSONAL','MEJORAR LAS CONDICIONES DEL TRABAJO QUE POSEO','TENER MAYOR ACCESO LABORAL','CERCANÍA CON MI DOMICILIO','PORQUE ME GUSTA LA CARRERA','OTRO'],
            'conocimiento_instituto' => ['POR OTRA PERSONA','POR FACEBOOK','POR INSTAGRAM','POR LA TV','POR LA PÁGINA WEB DEL IES','POR LA RADIO','EN LA OFERTA EDUCATIVA','EN EL INSTITUTO ABIERTO','LO CONOCES PORQUE SOS DE LA ZONA','FUIMOS A TU ESCUELA','OTRO'],
            'seguridad_carrera' => ['SI','NO'],
            'como_ingresa' => ['FINALIZADO EL NIVEL MEDIO','ADEUDANDO MATERIAS','INGRESO POR ARTÍCULO 7°','EMPEZADO PERO NO CONCLUIDO UNA CARRERA DE NIVEL SUPERIOR','CONCLUÍDO UNA CARRERA DE NIVEL SUPERIOR','OTRO'],
            'tipo_nivel_medio' => ['SECUNDARIA ORIENTADA (5AÑOS)','SECUNDARIA EN ESCUELA TÉCNICA (6 AÑOS)','CENS','INGRESA POR ART.7MO'],
            'ayuda_para_estudiar' => ['SI','NO'],
            'horas_estudio' => ['MENOS DE 1 HORA','ENTRE 1 Y 2 HORAS','ENTRE 3 Y 4 HORAS','MAS DE 4 HORAS','NO LE DEDICO NINGUNA HORA'],
            'actividades_extras' => ['ACTIVIDADES FÍSICAS','ACTIVIDADES MUSICALES','ACTIVIDADES INTELECTUALES','ACTIVIDADES ARTÍSTICAS','ACTIVIDADES DE IMPACTO SOCIAL','NO REALIZO ACTIVIDAD EXTRA','OTRO'],
            'desc_actividades_extras' => ['ACTIVIDADES FÍSICAS','ACTIVIDADES MUSICALES','ACTIVIDADES INTELECTUALES','ACTIVIDADES ARTÍSTICAS','ACTIVIDADES DE IMPACTO SOCIAL','NO DESEO O PUEDO REALIZAR OTRA ACTIVIDAD EXTRA EDUCATIVA','YA REALIZO ACTIVIDAD EXTRAEDUCATIVA','OTRO'],
        ];
        


        $opcionesCheckbox = [
            'acceso_internet' => ['DESDE CELULAR CON DATOS', 'DESDE CASA EN RED', 'DESDE CASA DE CONOCIDO', 'DESDE CELULAR FAMILIAR', 'NO TIENE', 'DESDE RED PUBLICA O WIFI', 'OTRO'],
            'herramientas_tecnologicas' => ['TU CELULAR PERSONAL', 'PC', 'NOTEBOOK O NETBOOK', 'TABLET', 'CELULAR FAMILIAR', 'NO TENGO', 'OTRO'],
            'edad_hijos' => ['MENOS DE 45 DÍAS', 'DE 45 DÍAS A 6 MESES', 'DE 1 A 3 AÑOS', 'DE 4 Y 5 AÑOS', 'DE 6 A 13 AÑOS', 'DE 14 A 18 AÑOS', 'DE 19 A 21 AÑOS', 'MÁS DE 21 AÑOS', 'NO TENÉS HIJOS'],
            'situacion_salud' => ['ENFERMEDAD', 'DISCAPACIDAD', 'TRATAMIENTO MÉDICO PERMANENTE', 'TOMAR MEDICACIÓN PERMANENTE', 'BUEN ESTADO DE SALUD', 'PROBLEMÁTICA RELACIONADA A LA SALUD MENTAL', 'OTROS'],
            'subsidios' => ['PROGRESAR/ PRONAFE', 'MEDIO BOLETO', 'BECA MUNICIPAL', 'BECA DE TRANSPORTE', 'BECA DE FOTOCOPIAS', 'APORTE POR CAPACITACIÓN', 'IFE O PLAN SOCIAL', 'NO RECIBO NINGUNA'],
            'transporte_utilizado' => ['COLECTIVO', 'AUTO PROPIO', 'AUTO DE OTRA PERSONA', 'CAMINANDO UN TRAYECTO MAYOR DE 3 KM.', 'CAMINANDO UN TRAYECTO MENOR A 3 KM.', 'BICICLETA', 'MOTO'],
            'familia_enfermedad' => ['JEFE DE HOGAR', 'OTRO FAMILIA CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'familia_discapacidad' => ['JEFE DE HOGAR', 'OTRO FAMILIA CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'familia_obra_social' => ['JEFE DE HOGAR', 'OTRO FAMILIA CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'desalojo_vivienda' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'violencia_intrafamiliar' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'violencia_genero' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'fallecimiento_conviviente' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'situaciones_consumo' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'accidentes_graves' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'condenas_extramuros' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'embargo_judicial' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'problemas_judiciales' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'problemas_salud_mental' => ['JEFE DE HOGAR', 'INGRESANTE', 'OTRO CONVIVIENTE', 'NINGUNO POSEE PROBLEMA'],
            'dificultad_estudio' => ['SITUACIÓN ECONÓMICA', 'ACCESO AL TRANSPORTE', 'CUIDADO DE FAMILIAR', 'SI', 'ENFERMEDAD/DISCAPACIDAD', 'ACCESO AL MATERIAL DE TRABAJO', 'ACCESO A CONECTIVIDAD', 'NO CONTAR CON HERRAMIENTAS INFORMÁTICAS', 'NO CONTAR CON UN ESPACIO CÓMODO Y TRANQUILO PARA ESTUDIAR', 'OTRO'],
            'herramientas_estudio' => ['ELABORACIÓN DE RESÚMENES', 'ELABORACIÓN DE MAPAS CONCEPTUALES Y/O MAPAS MENTALES', 'SOLO LECTURA DEL MATERIAL BIBLIOGRÁFICO Y APUNTES DE CLASE', 'UTILIZACIÓN DE MATERIAL DE APOYO VISUAL Y/O AUDITIVO', 'ESTUDIO Y REPASO SOLO', 'ESTUDIO Y REPASO EN COMPAÑÍA DE OTRA/OTRAS PEROSONAS'],
            'lugar_trabajo' => ['HOSPITAL', 'MEDIOS DE COMUNICACIÓN', 'BODEGAS', 'FÁBRICAS', 'EMPRESAS', 'MUNICIPIO', 'LABORATORIOS', 'FINCA', 'ORGANISMOS ESTATALES', 'ORGANISMOS PRIVADOS', 'EMPRENDIMIENTOS', 'OTRO'],
            'horario_actividades' => ['MAÑANA', 'TARDE', 'NOCHE', 'EN NINGUN MOMENTO']
        ];
        




        $graficosBar = ['identidad_genero', 'empresa_telefono', 'condicion_laboral', 'subsidios','dificultad_estudio'];

        foreach ($opciones as $campo => $labels) {
            $datos[$campo] = [
                'labels' => $labels,
                'type' => in_array($campo, $graficosBar) ? 'bar' : 'pie',
                'data' => array_fill(0, count($labels), 0)
            ];
        }

        foreach ($opcionesCheckbox as $campo => $labels) {
            $datos[$campo] = [
                'labels' => $labels,
                'type' => in_array($campo, $graficosBar) ? 'bar' : 'pie',
                'data' => array_fill(0, count($labels), 0)
            ];
        }

        foreach ($encuestas as $encuesta) {

            foreach ($opciones as $index => $campo) {
                if ($index != 'edad_encuesta') {
                    $datos[$index]['data'][array_search(mb_strtoupper($encuesta[$index]), $opciones[$index])]++;
                }
            }

            foreach ($opcionesCheckbox as $index => $campoCheckbox) {
                $datos[$index] = $this->procesarCheckbox($datos, $opcionesCheckbox, $encuesta[$index], $index);
            }


            $edad = $encuesta->alumno->edad;

            if(is_numeric($edad))
            {
                if ($edad >= 18 && $edad <= 30) {
                    $index = $edad - 18;
                    $datos['edad_encuesta']['data'][$index]++;
                } elseif ($edad > 30) {
                    $datos['edad_encuesta']['data'][13]++; // Mayores de 30
                } elseif ($edad < 18) {
                    $datos['edad_encuesta']['data'][14]++; // Menores de 18
                }
            }
            
            // Otros campos similares...
        }
        
        $datos['dificultad_estudio']['labels'][3] = 'SUPERPOSICIÓN HORARIA CON EL TRABAJO';

        return $datos;
    }

    public function getEncuestas($parameters)
    {
        $encuestas = EncuestaSocioeconomica::whereHas('alumno', function ($query) use ($parameters) {
            $query->whereHas('carreras', function ($query) use ($parameters) {
                $query->where('carreras.id', $parameters['carrera_id']);
            })->whereHas('carreras', function ($query) use ($parameters) {
                $query->where('año', $parameters['año']);
            });
        })->get();

        return $encuestas;
    }

    private function procesarCheckbox($datos, $opciones, $encuesta_campo, $campo)
    {
        $array = explode('|', $encuesta_campo);
        foreach ($array as $opcion) {
            $opcion = mb_strtoupper(trim($opcion));
            if (in_array($opcion, $opciones[$campo])) {
                $datos[$campo]['data'][array_search($opcion, $opciones[$campo])]++;
            }
        }

        return $datos[$campo];
    }
}
