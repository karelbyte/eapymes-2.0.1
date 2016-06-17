<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Taxs_Update_Request extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'percent' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'percent.required' => 'Porciento es requerido.',
        ];
    }
}
