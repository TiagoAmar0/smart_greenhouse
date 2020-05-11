<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SensorActionsRequest extends FormRequest
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
    public function rules()
    {
        return [
            'sensor_id' => 'required|exists:sensors:id',
            'text' => 'required|max:191',
            'value' => 'max:191',
            'route' => 'required|max:191',
        ];
    }

    /**
     * Get the error messages
     *
     * @return array|string[]
     */
    function messages()
    {
        return [
            'sensor_id.required' => 'Tem de preencher o nome do sensor',
            'sensor_id.exists' => 'Esse sensor não existe',
            'text.required' => 'Tem de preencher o texto da ação',
            'text.max' => 'O texto da ação apenas pode ter no máximo 191 caracteres',
            'value.max' => 'O valor da ação apenas pode ter no máximo 191 caracteres',
            'route.required' => 'Tem de preencher a route da ação',
            'route.max' => 'A route da ação apenas pode ter no máximo 10 caracteres'
        ];
    }
}
