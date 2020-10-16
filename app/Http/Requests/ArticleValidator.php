<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleValidator extends FormRequest
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
            //'barcode' => 'sometimes|nullable|unique:articles,barcode,'.$this->id.',id',
            'description' => 'required|unique:articles,description,'.$this->id.',id',
            'print_name' => 'required|unique:articles,print_name,'.$this->id.',id'
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
            //'barcode.unique' => 'El código de barras ya existe',
            'description.required' => 'Ingrese la descripción',
            'print_name.required' => 'Ingrese la lista de precio',
            'price_update_level.required' => 'Ingrese Lista N°'
        ];
    }
}
