<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibroDigitalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'acta_inicio' => ['nullable'],
            'number' => ['required', 'integer'],
            'resoluciones_id' => ['required', 'exists:resoluciones'],
            'fecha_inicio' => ['nullable', 'date'],
            'sede_id' => ['required', 'exists:sedes'],
            'resolucion_original' => ['nullable'],
            'operador_id' => ['required', 'exists:users'],
            'observaciones' => ['required'],
            'user_id' => ['required', 'exists:users'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
