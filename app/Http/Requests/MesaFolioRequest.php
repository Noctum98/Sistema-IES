<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MesaFolioRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'numero' => ['required', 'integer'],
            'turno' => ['nullable'],
            'fecha' => ['required', 'date'],
            'aprobados' => ['nullable', 'integer'],
            'desaprobados' => ['nullable', 'integer'],
            'ausentes' => ['nullable', 'integer'],
            'libro_digital_id' => ['required', 'exists:libros_digitales'],
            'mesa_id' => ['nullable', 'exists:mesas'],
            'master_materia_id' => ['required', 'exists:materias'],
            'presidente' => ['required', 'exists:users'],
            'vocal_1' => ['required', 'exists:users'],
            'use' => ['required'],
            'vocal_2' => ['required', 'exists:users'],
            'coordinador_id' => ['required', 'exists:users'],
            'presidente_id' => ['nullable', 'exists:users'],
            'vocal_1_id' => ['required', 'exists:users'],
            'vocal_2_id' => ['required', 'exists:users'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
