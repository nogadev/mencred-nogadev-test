<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerValidator extends FormRequest
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
            //'code' => 'required|unique:customers,code,'.$this->id.',id',
            'name'                      => 'required',
            'commerce_id'               => 'required',
            'commercial_address'        => 'required',
            'commercial_district_id'    => 'required',
            'commercial_town_id'        => 'required',
            'commercial_neighborhood_id'=> 'required',
            'commercial_between'        => 'required',
            'personal_address'          => 'required',
            'personal_district_id'      => 'required',
            'personal_town_id'          => 'required',
            'personal_neighborhood_id'  => 'required',
            'personal_between'          => 'required', 
            'doc_number'                => 'required',
            'birthday'                  => 'required',
            'horary'                    => 'required',
            'route_id'                  => 'required',
            'seller_id'                 => 'required',
            'antiquity'                 => 'required'
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
            'name.required'                      => 'Ingrese un nombre',
            'commerce_id.required'               => 'Elija un tipo de comercio',
            'commercial_address.required'        => 'Ingrese una dirección comericial',
            'commercial_district_id.required'    => 'Ingrese una departamento comericial',
            'commercial_town_id.required'        => 'Ingrese una ciudad comericial',
            'commercial_neighborhood_id.required'=> 'Ingrese una barrio comericial',
            'commercial_between.required'        => 'Ingrese una entre calles comericial',
            'personal_address.required'          => 'Ingrese una dirección personal',
            'personal_district_id.required'      => 'Ingrese un departamento personal',
            'personal_town_id.required'          => 'Ingrese una ciudad personal',
            'personal_neighborhood_id.required'  => 'Ingrese una barrio personal',
            'personal_between.required'          => 'Ingrese una entre calles personal',
            'doc_number.required'                => 'Ingrese número de documento',
            'birthday.required'                  => 'Ingrese fecha de nacimiento',
            'horary.required'                    => 'Ingrese horario',
            'route_id.required'                  => 'Ingrese recorrido',
            'seller_id.required'                 => 'Ingrese vendedor',
            'antiquity.required'                 => 'Ingrese antiguedad'

        ];
    }
}
