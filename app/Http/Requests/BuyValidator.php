<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyValidator extends FormRequest
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
            'supplier_id'       => 'required',
            'date'              => 'required',
            'voucher_type_id'   => 'required',
            'subsidiary_number' => 'required',
            'voucher_number'    => 'required',
            'company_id'        => 'required',
            'total'             => 'required|not_in:0',
            'store_id'          => 'required'
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
            'supplier_id.required' => 'Seleccione el proveedor',
            'date.required' => 'Seleccione la fecha',
            'voucher_type_id.required' => 'Seleccione el tipo de comprobante',
            'subsidiary_number.required' => 'Complete el numero de comprobante',
            'voucher_number.required' => 'Complete el numero de comprobante',
            'company_id.required' => 'Seleccione la empresa',
            'total.required' => 'El comprobante no está valorizado',
            'total.not_in' => 'El comprobante no está valorizado',
            'store_id.required' => 'Seleccione el depósito de destino'           
        ];
    }
}
