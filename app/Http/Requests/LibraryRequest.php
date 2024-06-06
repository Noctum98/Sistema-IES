<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibraryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required|string|min:3|max:255'],
            'link' => ['required|url'],
            'orden' => ['nullable|integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
