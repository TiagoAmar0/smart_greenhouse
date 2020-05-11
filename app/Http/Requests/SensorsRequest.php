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


        $sensor = Sensor::whereId($this->id);
        $rules = [
            'name' => 'required|unique:sensors|max:191',
            'image' => 'required|image|max:2048',
            'metric' => 'required|max:10'
        ];

        if ($this->getMethod() == 'PATCH') {
            $id= \Route::input('sensor');

            $rules['image'] = '';
            $rules['name'] = 'required|unique:sensors,name,'.$id.'|max:191';
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
           'name.unique' => 'O nome do sensor deve ser único',
           'name.max' => 'O nome sensor apenas pode ter no máximo 191 caracteres',
           'image.required' => 'Tem de preencher a imagem do sensor',
           'metric.required' => 'Tem de preencher a unidade do sensor',
           'metric.max' => 'A unidade do sensor apenas pode ter no máximo 10 caracteres'
       ];
    }
}
