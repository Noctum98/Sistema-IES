<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CondicionCarreraRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => ['required'],
            'identificador' => ['required'],
            'habilitado' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
