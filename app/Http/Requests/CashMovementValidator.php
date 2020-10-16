<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashMovementValidator extends FormRequest
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
            'movementtype_id'   => 'required',
            'mov_reason_id' => 'required',
            'amount'            => 'required',
            'description'       => 'required',

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
            'movementtype_id.required'      => 'Ingrese un tipo de movimiento',
            'mov_reason_id.required'    => 'Elija un motivo',
            'amount.required'               => 'Ingrese el monto',
            'description.required'          => 'Ingrese el detalle',
        ];
    }
}
