<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Model\Sensor;

class SensorsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){

        return [
            'metric' => 'required|max:10'
        ];

        return $rules;
    }

    /**
     * Get the error messages
     *
     * @return array|string[]
     */
    function messages()
    {
       return [
           'metric.required' => 'Tem de preencher a unidade do sensor',
           'metric.max' => 'A unidade do sensor apenas pode ter no máximo 10 caracteres'
       ];
    }
}
