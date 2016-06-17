<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Users_Update_Request extends Request
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
            'idperson' => 'required',
            'idprofile' => 'required',
            'nick'=>array('required', 'regex:/^[0-9a-zA-Z]+$/', 'min:6'),
        ];
    }
    public function messages()
    {
        return [
            'idperson.required' => 'La persona es requerida.',
            'idprofile.required' => 'Perfil requerido.',
            'nick.required' => 'Nombre de usuario requerido.',
            'nick.regex' => 'Formato de Alias no válido.',
            'nick.min' => 'El Alias debe contener al menos 6 caracteres',
        ];
    }
}
