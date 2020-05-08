<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        $rules = [
            'name' => 'required|max:191',
            'image' => 'required|image|max:2048',
            'metric' => 'required|max:10'
        ];

        if ($this->getMethod() == 'PATCH') {
            $rules['image'] = '';
            $rules['image_value'] = 'required';
        }

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
           'name.required' => 'Tem de preencher o nome do sensor',
           'name.max' => 'O nome sensor apenas pode ter no máximo 191 caracteres',
           'image.required' => 'Tem de preencher a imagem do sensor',
           'metric.required' => 'Tem de preencher a unidade do sensor',
           'metric.max' => 'A unidade do sensor apenas pode ter no máximo 10 caracteres'
       ];
    }
}
