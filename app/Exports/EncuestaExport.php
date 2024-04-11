<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EncuestaExport implements FromCollection, WithHeadings
{
    protected $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->datos->map(function ($encuesta) {
            return $camposExcel = [
                'Apellido y Nombre' => mb_strtoupper($encuesta['alumno']['apellidos']) . ' ' . $encuesta['alumno']['nombres'],
                'DNI' => $encuesta['alumno']['dni'],
                'CUIL' => $encuesta['alumno']['cuil'],
                'Nombre preferido' => $encuesta['nombre_preferido'],
                'Identidad de género' => $encuesta['identidad_genero'],
                'Edad' => $encuesta['alumno']['edad'],
                'Empresa de Teléfono' => $encuesta['empresa_telefono'],
                'Accesso a Internet' => $encuesta['acceso_internet'],
                'Herramientas Tecnológicas' => $encuesta['herramientas_tecnologicas'],
                '¿Durante el ciclo lectivo anterior estuviste vinculado/a a alguna actividad educativa de manera virtual?' => $encuesta['vinculacion_ciclo'],
                'Condición laboral del/de la estudiante' => $encuesta['condicion_laboral'],
                'Lugar y Horario de trabajo' => $encuesta['lugar_y_horario_trabajo'],
                '¿Tu trabajo está relacionado con la carrera en la que te has inscripto/que estás cursando?' => $encuesta['trabajo_relacionado'],
                '¿Sos jefe/a de hogar?' => $encuesta['jefe_hogar'],
                '¿Tenés hijos/as a cargo?' => $encuesta['hijos_a_cargo'],
                'Cantidad de hijos' => $encuesta['cantidad_hijos'],
                'Edad de tus hijos' => $encuesta['edad_hijos'],
                'En cuanto a tu situación de salud, declaras poseer' => $encuesta['situacion_salud'],
                'CUD' => $encuesta['cud'],
                'Obra Social' => $encuesta['obra_social'],
                'En el presente ciclo lectivo recibís o has gestionado' => $encuesta['subsidios'],
                'Kilómetros de distancia desde tu domicilio hasta el IES' => $encuesta['distancia_ies'],
                'Transporte utilizado para concurrir al IES' => $encuesta['transporte_utilizado'],
                'Cantidad de personas que conviven con vos' => $encuesta['cantidad_convivientes'],
                'Cantidad de lugares para dormir que posee tu vivienda' => $encuesta['cantidad_lugares_dormir'],
                'Ingresos mensuales del grupo familiar' => $encuesta['ingresos_mensuales'],
                'Condición laboral del Jefe/a de hogar' => $encuesta['condicion_laboral_jefe_hogar'],
                'Máximo nivel educativo alcanzado por el Padre' => $encuesta['maximo_nivel_educativo_padre'],
                'Máximo nivel educativo alcanzado por la Madre' => $encuesta['maximo_nivel_educativo_madre'],
                'En cuanto a la situación de salud de tu grupo conviviente, poseen: Enfermedad' => $encuesta['familia_enfermedad'],
                'En cuanto a la situación de salud de tu grupo conviviente, poseen: Discapacidad' => $encuesta['familia_discapacidad'],
                'En cuanto a la situación de salud de tu grupo conviviente, poseen: Obra Social' => $encuesta['familia_obra_social'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Desalojo' => $encuesta['desalojo_vivienda'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Violencia Intrafamiliar' => $encuesta['violencia_intrafamiliar'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Violencia Género' => $encuesta['violencia_genero'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Fallecimiento Conviviente' => $encuesta['fallecimiento_conviviente'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Situaciones de consumo Problemático' => $encuesta['situaciones_consumo'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Accidentes graves' => $encuesta['accidentes_graves'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Condenas extramuros' => $encuesta['condenas_extramuros'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Embargo judicial al ingreso' => $encuesta['embargo_judicial'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Problemas judiciales' => $encuesta['problemas_judiciales'],
                '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Problemas de salud mental' => $encuesta['problemas_salud_mental'],
                'En tu vivienda contás con:Agua Potable' => $encuesta['agua_potable'],
                'En tu vivienda contás con:Luz Electrica' => $encuesta['luz_electrica'],
                'En tu vivienda contás con:Gas Envasado' => $encuesta['gas_envasado'],
                'En tu vivienda contás con:Gas Natural' => $encuesta['gas_natural'],
                'Tenencia de la vivienda' => $encuesta['tenencia_vivienda'],
                'El baño de la vivienda: Dentro de la vivienda' => $encuesta['baño_dentro'],
                'El baño de la vivienda: Con Descarga de agua' => $encuesta['baño_con_descarga'],
                'Piso de la vivienda es de:' => $encuesta['piso_vivienda'],
                'La construcción de la vivienda es de:' => $encuesta['construccion_vivienda'],
                'Condición general de la vivienda' => $encuesta['condicion_vivienda'],
                'Motivos que te animan a seguir estudiando:' => $encuesta['motivo_para_estudiar'],
                '¿Cómo conociste el instituto?' => $encuesta['conocimiento_instituto'],
                '¿Estás completamente seguro/a de la carrera elegida?' => $encuesta['seguridad_carrera'],
                'Fundamentá tu respuesta' => $encuesta['fundamento_seguridad'],
                'Ingresas al IES habiendo:' => $encuesta['como_ingresa'],
                'Con respecto a los estudios de Nivel Medio, menciona donde los realizaste' => $encuesta['tipo_nivel_medio'],
                'Materia que menos te costó del nivel secundario/ del año anterior del cursado' => $encuesta['materia_menos_costosa'],
                'Materia que mas te costó del nivel secundario/ del año anterior del cursado' => $encuesta['materia_mas_costosa'],
                '¿Considerás que necesitas ayuda para estudiar?' => $encuesta['ayuda_para_estudiar'],
                '¿Cuánto tiempo le dedicas al estudio?' => $encuesta['horas_estudio'],
                'Considerás que podrías tener dificultades para continuar los estudios por las siguientes razones:' => $encuesta['dificultad_estudio'],
                'Herramientas de estudio' => $encuesta['herramientas_estudio'],
                '¿En qué lugar te gustaría trabajar?' => $encuesta['lugar_trabajo'],
                '¿Sobre qué temas te gustaría recibir más capacitación?' => $encuesta['temas_capacitacion'],
                '¿Realizás actividades extras a la carrera? especificá si es así' => $encuesta['actividades_extras'],
                '¿Te gustaría hacer alguna? especificá si es así' => $encuesta['desc_actividades_extras'],
                '¿En qué horario podrías realizar estas actividades?' => $encuesta['horario_actividades'],
                '¿Quisieras agregar algún otro dato que te parezca importante mencionar ya que podría afectar tu desempeño académico?' => $encuesta['otro_comentario']
            ];
        });
    }

    public function headings(): array
    {
        return  $camposExcel = [
            'Apellido y Nombre',
            'DNI',
            'CUIL',
            'Nombre preferido',
            'Identidad de género',
            'Edades',
            'Empresa de Teléfono',
            'Accesso a Internet',
            'Herramientas Tecnológicas',
            '¿Durante el ciclo lectivo anterior estuviste vinculado/a a alguna actividad educativa de manera virtual?',
            'Condición laboral del/de la estudiante',
            '¿Tu trabajo está relacionado con la carrera en la que te has inscripto/que estás cursando?',
            '¿Sos jefe/a de hogar?',
            '¿Tenés hijos/as a cargo?',
            'Edad de tus hijos',
            'En cuanto a tu situación de salud, declaras poseer',
            'CUD',
            'Obra Social',
            'En el presente ciclo lectivo recibís o has gestionado',
            'Kilómetros de distancia desde tu domicilio hasta el IES',
            'Transporte utilizado para concurrir al IES',
            'Cantidad de personas que conviven con vos',
            'Cantidad de lugares para dormir que posee tu vivienda',
            'Ingresos mensuales del grupo familiar',
            'Condición laboral del Jefe/a de hogar',
            'Máximo nivel educativo alcanzado por el Padre',
            'Máximo nivel educativo alcanzado por la Madre',
            'En cuanto a la situación de salud de tu grupo conviviente, poseen: Enfermedad',
            'En cuanto a la situación de salud de tu grupo conviviente, poseen: Discapacidad',
            'En cuanto a la situación de salud de tu grupo conviviente, poseen: Obra Social',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Desalojo',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Violencia Intrafamiliar',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Violencia Género',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Fallecimiento Conviviente',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Situaciones de consumo Problemático',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Accidentes graves',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Condenas extramuros',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Embargo judicial al ingreso',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Problemas judiciales',
            '¿Has atravesado vos o tu grupo familiar conviviente, alguna de las siguientes situaciones? Problemas de salud mental',
            'En tu vivienda contás con:Agua Potable',
            'En tu vivienda contás con:Luz Electrica',
            'En tu vivienda contás con:Gas Envasado',
            'En tu vivienda contás con:Gas Natural',
            'Tenencia de la vivienda',
            'El baño de la vivienda: Dentro de la vivienda',
            'El baño de la vivienda: Con Descarga de agua',
            'Piso de la vivienda es de:',
            'La construcción de la vivienda es de:',
            'Condición general de la vivienda',
            'Motivos que te animan a seguir estudiando:',
            '¿Cómo conociste el instituto?',
            '¿Estás completamente seguro/a de la carrera elegida?',
            'Fundamentá tu respuesta',
            'Ingresas al IES habiendo:',
            'Con respecto a los estudios de Nivel Medio, menciona donde los realizaste',
            'Materia que menos te costó del nivel secundario/ del año anterior del cursado',
            'Materia que mas te costó del nivel secundario/ del año anterior del cursado',
            '¿Considerás que necesitas ayuda para estudiar?',
            '¿Cuánto tiempo le dedicas al estudio?',
            'Considerás que podrías tener dificultades para continuar los estudios por las siguientes razones:',
            'Herramientas de estudio',
            '¿En qué lugar te gustaría trabajar?',
            '¿Sobre qué temas te gustaría recibir más capacitación?',
            '¿Realizás actividades extras a la carrera? especificá si es así',
            '¿Te gustaría hacer alguna? especificá si es así',
            '¿En qué horario podrías realizar estas actividades?',
            '¿Quisieras agregar algún otro dato que te parezca importante mencionar ya que podría afectar tu desempeño académico?'
        ];
    }
}
