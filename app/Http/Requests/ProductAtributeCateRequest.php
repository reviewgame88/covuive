<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductAtributeCateRequest extends Request
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
            'txtCateName'=>'required|unique:product_atr_cates,name',
        ];
    }
    
    public function messages(){
        return [
            'txtCateName.required' => 'Tên th? lo?i không du?c d? tr?ng',
            'txtCateName.unique' => 'Tên th? lo?i này dã t?n t?i'
        ];
    }
}
