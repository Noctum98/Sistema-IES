<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegimenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'identifier' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
