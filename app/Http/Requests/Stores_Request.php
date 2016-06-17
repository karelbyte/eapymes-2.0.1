<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Stores_Request extends Request
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
            'name' => 'required|unique:stores',
            'idtype' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nombre de almacen requerido.',
            'name.unique'  => 'El almacen tiene que ser unico.',
            'idtype.required' => 'El tipo de almacen es requerido.',
        ];
    }
}
