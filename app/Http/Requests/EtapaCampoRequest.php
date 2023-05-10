<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtapaCampoRequest extends FormRequest
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
            'primera_evaluacion' => ['numeric','max:10'],
            'segunda_evaluacion' => ['numeric','max:10'],
            'tercera_evaluacion' => ['numeric','max:10'],
            'asistencia' => ['numeric','max:100']
        ];
    }
}
