<?php

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class TipoCalificacionesRequest extends FormRequest
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
            'nombre' => ['required','max:255'],
            'descripcion' => ['required','min:1'],
        ];
    }

    public function withValidator($validator)
    {
        //
    }
}