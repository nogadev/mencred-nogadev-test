<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NeighborhoodValidator extends FormRequest
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
            'town_id' => 'required',
            'name' => [
                'required',
                Rule::unique('neighborhoods','name')
                    ->ignore($this->id, 'id')
                    ->where('town_id',$this->request->get('town_id') !== null ? $this->request->get('town_id') : 0)
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
            'town_id.required' => 'Seleccione la localidad',
            'name.required' => 'Ingrese el nombre',
            'name.unique' => 'El nombre ya existe en la localidad seleccionada'
        ];
    }
}

