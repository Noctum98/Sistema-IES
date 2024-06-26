<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibroPapelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'number' => ['required', 'integer'],
            'roman' => ['required'],
            'fecha_inicio' => ['required', 'date'],
            'operador_inicio' => ['required', 'exists:users'],
            'sede_id' => ['required', 'exists:sedes'],
            'acta_inicio' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
