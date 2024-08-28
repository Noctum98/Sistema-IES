<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FolioNotaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'orden' => ['required', 'integer'],
            'permiso' => ['nullable', 'integer'],
            'escrito' => ['nullable', 'integer'],
            'oral' => ['nullable', 'integer'],
            'definitiva' => ['nullable', 'integer'],
            'acta_volante_id' => ['nullable', 'exists:actas_volantes'],
            'mesa_folio_id' => ['required', 'exists:mesa_folios'],
            'alumno_id' => ['nullable', 'exists:alumnos'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
