<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class resolucionesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'title' => ['required'],
            'duration' => ['required', 'integer'],
            'resolution' => ['required'],
            'type' => ['required'],
            'vaccines' => ['required'],
            'estados_id' => ['required', 'exists:estados'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
