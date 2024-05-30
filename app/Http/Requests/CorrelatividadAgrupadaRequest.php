<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorrelatividadAgrupadaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'Name' => ['required'],
            'Description' => ['required'],
            'Identifier' => ['required'],
            'resoluciones_id' => ['required', 'exists:resoluciones'],
            'user_id' => ['required', 'exists:users'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
