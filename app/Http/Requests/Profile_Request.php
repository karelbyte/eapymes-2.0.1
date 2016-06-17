<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Profile_Request extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:profiles',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'name.unique'  => 'El nombre tiene que ser único.',
        ];
    }
}
