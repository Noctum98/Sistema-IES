<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarrerasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sede_id'   =>  ['required','numeric'],
            'turno'     =>  ['required','string'],
            'nombre'    =>  ['required'],
            'titulo'    =>  ['required'],
            'años'      =>  ['required','numeric','max:4'],
            'modalidad' =>  ['required','alpha'],
            'vacunas'   =>  ['required','alpha']
        ];
    }
}
