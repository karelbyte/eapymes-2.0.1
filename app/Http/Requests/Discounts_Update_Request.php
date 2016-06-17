<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Discounts_Update_Request extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:discounts',
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
