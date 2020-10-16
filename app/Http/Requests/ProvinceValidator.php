<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProvinceValidator extends FormRequest
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
            'country_id' => 'required',
            'name' => [
                'required',
                Rule::unique('provinces','name')
                    ->ignore($this->id, 'id')
                    ->where('country_id',$this->request->get('country_id') !== null ? $this->request->get('country_id') : 0)
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
            'country_id.required' => 'Seleccione el país',
            'name.required' => 'Ingrese el nombre',
            'name.unique' => 'El nombre ya existe en el país seleccionado'
        ];
    }
}
