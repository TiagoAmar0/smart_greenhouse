<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatesTextRequest extends FormRequest
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
            'equipment_id' => 'required|exists:equipments,id',
            'text' => 'required|max:191',
            'value' => 'required|max:191',
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
            'equipment_id.required' => 'Tem de preencher o nome do equipamento',
            'equipment_id.exists' => 'Esse equipamento não existe',
            'value.required' => 'Tem de preencher o valor do estado',
            'value.max' => 'O valor do estado apenas pode ter no máximo 191 caracteres',
            'text.required' => 'Tem de preencher o texto do estado',
            'texto.max' => 'O texto do estado apenas pode ter no máximo 10 caracteres'
        ];
    }
}
