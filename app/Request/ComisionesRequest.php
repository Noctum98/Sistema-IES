<?php

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class ComisionesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'carrera_id' => ['required'],
            'nombre' => ['required','max:255'],
            'año' => ['required','min:1'],
            'ciclo_lectivo' => ['required']
        ];
    }

    public function withValidator($validator)
    {
        //
    }
}