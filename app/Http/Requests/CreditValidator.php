<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditValidator extends FormRequest
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
            'customer_id'   => 'required',
            'created_date'  => 'required',
            'company_id'    => 'required',
            'seller_id'     => 'required',
            'delivery_id'   => 'required',
            'store_id'      => 'required',
            'total_amount'  => 'required|not_in:0',
            'fee_amount'    => 'required|not_in:0',
            'fee_quantity'  => 'required|not_in:0'
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
            'customer_id.required'  => 'Seleccione el cliente',
            'seller_id.required'    => 'Seleccione el vendedor',
            'delivery_id.required'  => 'Seleccione el transporte',
            'created_date.required' => 'Seleccione la fecha',
            'company_id.required'   => 'Seleccione la empresa',
            'total_amount.required' => 'El comprobante no está valorizado',
            'total_amount.not_in'   => 'El comprobante no está valorizado',
            'fee_amount.required'   => 'Ingrese un valor de cuota',
            'fee_amount.not_in'     => 'El valor de cuota no puede ser 0',
            'fee_quantity.required' => 'Ingrese una cantidad de cuotas',
            'fee_quantity.not_in'   => 'La cantidad de cuotas no puede ser 0',
            'store_id.required'     => 'Seleccione el deposito de origen'
        ];
    }
}
