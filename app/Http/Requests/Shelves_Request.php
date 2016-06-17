<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Shelves_Request extends Request
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
            'name' => 'required',
            'idstore' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nombre de estante requerido.',
            'idstore.required' => 'El almacen donde se ubica requerido.',
        ];
    }
}
