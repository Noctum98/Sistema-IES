<?php

namespace App\Http\Requests\Alumno;

use Illuminate\Foundation\Http\FormRequest;

class EncuestaSocioeconomicaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alumno_id' => 'required',
            'nombre_preferido' => 'required',
            'identidad_genero' => 'required',
            'identidad_genero_otra' => 'string',
            'edad_encuesta' => 'number',
            'empresa_telefono' => 'required',
            'acceso_internet' => 'required',
            'herramientas_tecnologicas' => 'required',
            'vinculacion_ciclo' => 'required',
            'condicion_laboral' => 'required',
            'lugar_y_horario_trabajo' => 'required',
            'trabajo_relacionado' => 'required',
            'jefe_hogar' => 'required',
            'hijos_a_cargo' => 'required',
            'cantidad_hijos' => 'required',
            'edad_hijos' => 'required',
            'obra_social' => 'required',
            'subsidios' => 'required',
            'distancia_ies' => 'required',
            'transporte_utilizado' => 'required',
            'cantidad_convivientes' => 'required',
            'cantidad_lugares_dormir' => 'required',
            'ingresos_mensuales' => 'required',
            'condicion_laboral_jefe_hogar' => 'required',
            'maximo_nivel_educativo_padre' => 'required',
            'maximo_nivel_educativo_madre' => 'required',
            'familia_enfermedad' => 'required',
            'familia_discapacidad' => 'required',
            'familia_obra_social' => 'required',
            'desalojo_vivienda' => 'required',
            'violencia_intrafamiliar' => 'required',
            'violencia_genero' => 'required',
            'fallecimiento_conviviente' => 'required',
            'situaciones_consumo' => 'required',
            'accidentes_graves' => 'required',
            'condenas_extramuros' => 'required',
            'embargo_judicial' => 'required',
            'problemas_judiciales' => 'required',
            'agua_potable' => 'required',
            'luz_electrica' => 'required',
            'gas_envasado' => 'required',
            'gas_natural' => 'required',
            'tenencia_vivienda' => 'required',
            'baño_dentro' => 'required',
            'baño_con_descarga' => 'required',
            'piso_vivienda' => 'required',
            'construccion_vivienda' => 'required',
            'condicion_vivienda' => 'required'
        ];
    }
}
