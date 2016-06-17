<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Persons_Request extends Request
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
            'idtype'=>'required',
            'idreason'=>'required',
            'comercial_name'=>'required',
            'name' => 'required|unique:persons',
            'address'=>'required',
            'zip'=>array('required', 'regex:/^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$/'),
            'state'=>'required',
            'country'=>'required',
            'email' => 'required|email|unique:persons',
            'curp'=>array('required', 'regex:/^([a-z]{4})([0-9]{6})([a-z]{6})([0-9]{2})$/i'),
            'rfc'=>array('required', 'regex:/^([A-Z,Ñ,&]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})$/'),

        ];
    }
    public function messages()
    {
        return [
            'idtype.required' => 'El tipo de persona es requerido.',
            'idreason.required' => 'La razon social es requerida.',
            'name.required' => 'El nombre es requerido.',
            'name.unique' => 'El nombre tiene que ser unico.',
            'comercial_name.required' => 'El nombre comercial es requerido.',
            'address.required' => 'La direción es requerida.',
            'zip.required' => 'El codigo postal es requerido.',
            'zip.regex' => 'Formato de codigo postal no válido.',
            'state.required' => 'El estado es requerido.',
            'country.required' => 'El pais es requerido.',
            'email.required' => 'El correo electronico es requerido.',
            'email.email' => 'Formato de correo electronico no válido.',
            'email.unique' => 'El  correo electronico tiene que ser único.',
            'curp.required' => 'La clave unica de registro de población es requerida.',
            'curp.regex' => 'Formato de curp no válido.',
            'rfc.required' => 'El registro federal de contribuyente es requerido.',
            'rfc.regex' => 'Formato de rfc no válido.',

        ];
    }
}
