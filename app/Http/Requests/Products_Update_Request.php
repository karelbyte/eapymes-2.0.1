<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Products_Update_Request extends Request
{
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
            'code' => 'required',
            'name' => 'required',
            'price' => array('required',  'regex:/^(\d|-)?(\d|,)*\.?\d*$/'),
            'idmeasure' => 'required',
            'idcategorie' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'El codigo es requerido.',
            'name.required' => 'El nombre es requerido.',
            'price.required' => 'El precio es requerido.',
            'price.regex' => 'Formato del precio no válido.',
            'idmeasure.required' => 'La uniad de medida es requerida.',
            'idcategorie.required' => 'La categoria es requerida.',
        ];
    }
}
