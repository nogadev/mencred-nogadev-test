<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TownValidator extends FormRequest
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
            'district_id' => 'required',
            'name' => [
                'required',
                Rule::unique('towns','name')
                    ->ignore($this->id, 'id')
                    ->where('district_id',$this->request->get('district_id') !== null ? $this->request->get('district_id') : 0)
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
            'district_id.required' => 'Seleccione el departamento',
            'name.required' => 'Ingrese el nombre',
            'name.unique' => 'El nombre ya existe en el departamento seleccionado'
        ];
    }
}