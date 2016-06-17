<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Profile_Update_Request extends Request
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
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido.',
        ];
    }
}
