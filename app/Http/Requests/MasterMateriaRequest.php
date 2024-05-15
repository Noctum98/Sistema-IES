<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterMateriaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'year' => ['required', 'integer'],
            'field_stage' => ['boolean'],
            'delayed_closing' => ['boolean'],
            'resoluciones_id' => ['required', 'exists:resoluciones'],
            'regimen_id' => ['required', 'exists:regimens'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
