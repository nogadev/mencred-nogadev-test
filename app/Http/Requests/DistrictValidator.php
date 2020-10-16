<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DistrictValidator extends FormRequest
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
            'province_id' => 'required',
            'name' => [
                'required',
                Rule::unique('districts','name')
                    ->ignore($this->id, 'id')
                    ->where('province_id',$this->request->get('province_id') !== null ? $this->request->get('province_id') : 0)
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'province_id.required' => 'Seleccione la provincia',
            'name.required' => 'Ingrese el nombre',
            'name.unique' => 'El nombre ya existe en la provincia seleccionada'
        ];
    }
}
