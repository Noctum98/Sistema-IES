<?php

namespace App\Services\Alumno;

use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Proceso;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EncuestaSocioeconomicaService
{
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
            'cantidad_lugares_dormir' => ['MONOAMBIENTE', 'SOLO UNA HABITACION', 'DOS HABITACIONES', 'TRES O MAS HABITACIONES']
        ];
        
        $opcionesCheckbox = [
            'acceso_internet' => ['DESDE CELULAR CON DATOS', 'DESDE CASA EN RED', 'DESDE CASA DE CONOCIDO', 'DESDE CELULAR FAMILIAR', 'NO TIENE', 'DESDE RED PUBLICA O WIFI', 'OTRO'],
            'herramientas_tecnologicas' => ['TU CELULAR PERSONAL', 'PC', 'NOTEBOOK O NETBOOK', 'TABLET', 'CELULAR FAMILIAR', 'NO TENGO', 'OTRO'],
            'edad_hijos' => ['MENOS DE 45 DÍAS', 'DE 45 DÍAS A 6 MESES', 'DE 1 A 3 AÑOS', 'DE 4 Y 5 AÑOS', 'DE 6 A 13 AÑOS', 'DE 14 A 18 AÑOS', 'DE 19 A 21 AÑOS', 'MÁS DE 21 AÑOS', 'NO TENÉS HIJOS'],
            'situacion_salud' => ['ENFERMEDAD', 'DISCAPACIDAD', 'TRATAMIENTO MÉDICO PERMANENTE', 'TOMAR MEDICACIÓN PERMANENTE', 'BUEN ESTADO DE SALUD', 'PROBLEMÁTICA RELACIONADA A LA SALUD MENTAL', 'OTROS'],
            'subsidios' => ['PROGRESAR/ PRONAFE', 'MEDIO BOLETO', 'BECA MUNICIPAL', 'BECA DE TRANSPORTE', 'BECA DE FOTOCOPIAS', 'APORTE POR CAPACITACIÓN', 'IFE O PLAN SOCIAL', 'NO RECIBO NINGUNA'],
            'transporte_utilizado' => ['COLECTIVO', 'AUTO PROPIO', 'AUTO DE OTRA PERSONA', 'CAMINANDO UN TRAYECTO MAYOR DE 3 KM.', 'CAMINANDO UN TRAYECTO MENOR A 3 KM.', 'BICICLETA', 'MOTO'],
        ];
        


        $graficosBar = ['identidad_genero', 'empresa_telefono', 'condicion_laboral','subsidios'];
        
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
            
            foreach($opciones as $index => $campo)
            {
                if($index != 'edad_encuesta')
                {
                    $datos[$index]['data'][array_search(mb_strtoupper($encuesta[$index]), $opciones[$index])]++;
                }
            }

            foreach($opcionesCheckbox as $index => $campoCheckbox)
            {
                $datos[$index] = $this->procesarCheckbox($datos, $opcionesCheckbox, $encuesta[$index], $index);
            }


            $edad = $encuesta->alumno->edad;
            if ($edad >= 18 && $edad <= 30) {
                $index = $edad - 18;
                $datos['edad_encuesta']['data'][$index]++;
            } elseif ($edad > 30) {
                $datos['edad_encuesta']['data'][13]++; // Mayores de 30
            } elseif ($edad < 18) {
                $datos['edad_encuesta']['data'][14]++; // Menores de 18
            }

            // Otros campos similares...
        }

        return $datos;
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
