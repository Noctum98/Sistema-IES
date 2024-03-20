<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EncuestaMotivacionalRequest extends FormRequest
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
            'motivo_para_estudiar' => 'required',
            'conocimiento_instituto' => 'required',
            'seguridad_carrera' => 'required',
            'fundamento_seguridad' => 'required',
            'como_ingresa' => 'required',
            'tipo_nivel_medio' => 'required',
            'materia_menos_costosa' => 'required',
            'materia_mas_costosa' => 'required',
            'ayuda_para_estudiar' => 'required',
            'horas_estudio' => 'required',
            'herramientas_estudio' => 'required',
            'lugar_trabajo' => 'required',
            'actividades_extras' => 'required'
        ];
    }
}
