<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticlePriceValidator extends FormRequest
{

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
        return [];
    }

    public function messages()
    {
        return [
            'price.required' => 'Ingrese el precio',
            'fee_amount.required' => 'Ingrese el monto de las cuotas',
            'fee_quantity.required' => 'Ingrese la cantidad de cuotas'
        ];
    }
}