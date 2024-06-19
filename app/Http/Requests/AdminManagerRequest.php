<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminManagerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'model' => ['required'],
            'name' => ['required'],
            'link' => ['required'],
            'enabled' => ['boolean'],
            'icon' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
