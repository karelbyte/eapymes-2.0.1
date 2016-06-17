<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Taxs_Request extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:taxs',
            'percent' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'name.unique' => 'El impuesto ya existe.',
            'percent.required' => 'Porciento es requerido.',
        ];
    }
}