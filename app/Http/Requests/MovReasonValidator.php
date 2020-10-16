<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovReasonValidator extends FormRequest
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
            'description'  => 'required',
            'mov_type_id'  => 'required'
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
            'mov_type_id.required'  => 'Seleccione el tipo',
            'description.required'    => 'Ingrese un nombre al motivo'
        ];
    }
}