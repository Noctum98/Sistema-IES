<?php

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class RegularidadesRequest extends FormRequest
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
            'proceso_id' => ['required'],
            'fecha_regularidad' => ['required'],
            'estado_id' => ['required'],
            'ciclo_anterior' => 'nullable|numeric|gte:1986',
            'observaciones' => 'required|min:5',
        ];
    }

    public function withValidator($validator)
    {
        //
    }
}
