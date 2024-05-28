<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgrupadaMateriaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'correlatividad_agrupada_id' => ['required', 'exists:correlatividad_agrupadas'],
            'master_materia_id' => ['required', 'exists:master_materias'],
            'user_id' => ['required', 'exists:users'],
            'disabled' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
