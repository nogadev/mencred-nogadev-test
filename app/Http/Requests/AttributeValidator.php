<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Attribute;
use App\Models\ArticleCategory;

class AttributeValidator extends FormRequest
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
        $rules = [];
        $rules['article_category_id'] = 'required';
        $rules['name'] = [
            'required',
            Rule::unique('attributes','name')
                ->ignore($this->id, 'id')
                ->where('article_category_id', $this->request->get('article_category_id') !== null ? $this->request->get('article_category_id') : 0)                
        ];
        
        if($this->request->get('id') == 0){
            $attributes = Attribute::withTrashed()
                                ->where('article_category_id', $this->request->get('article_category_id'))
                                ->get();
            //die($attributes);
            if ($attributes->count() == 4){
                $rules['id'] = 'size:4';
            };
        };
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'article_category_id.required' => 'Seleccione la categoría',
            'name.required' => 'Ingrese el nombre',
            'name.unique' => 'El nombre ya existe en la categoría seleccionada',
            'id.size'=> 'No puede cargar mas de :size atributos por categoría',
        ];
    }
}
