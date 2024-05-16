<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadoResolucionesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'identifier' => ['required'],
            'disabled' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
