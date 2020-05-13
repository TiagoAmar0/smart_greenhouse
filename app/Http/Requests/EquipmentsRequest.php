<?php

namespace App\Http\Requests;

use App\Model\Equipment;
use Illuminate\Foundation\Http\FormRequest;

class EquipmentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id= \Route::input('equipment');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $equipment = Equipment::whereId($this->id);
        $rules = [
            'name' => 'required|unique:equipments|max:191',
            'image' => 'required|image|max:2048',
            'type' => 'required|in:1,2,3'
        ];

        if ($this->getMethod() == 'PATCH') {
            $id= \Route::input('equipment');
            $rules['image'] = '';
            $rules['name'] = 'required|unique:equipments,name,'.$id.'|max:191';
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
            'name.required' => 'Tem de preencher o nome do equipamento',
            'name.unique' => 'O nome do equipamento deve ser único',
            'type.required' => 'Tem de preencher o tipo do equipamento',
            'type.in' => 'O valor do tipo de equipamento é inválido',
            'name.max' => 'O nome equipamento apenas pode ter no máximo 191 caracteres',
            'image.required' => 'Tem de preencher a imagem do equipamento'
        ];
    }
}
