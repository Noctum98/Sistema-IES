<?php

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class EquivalenciasRequest extends FormRequest
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
            'nota' => ['required','max:10'],
            'resolution' => ['required','min:1'],
            'fecha' => ['required'],
        ];
    }

    public function withValidator($validator)
    {
        //
    }
}
