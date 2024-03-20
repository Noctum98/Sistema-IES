<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'valor' => ['required'],
            'min' => ['required', 'integer'],
            'max' => ['required', 'integer'],
            'year' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
