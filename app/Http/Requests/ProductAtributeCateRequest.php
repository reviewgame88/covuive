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
            'txtCateName.required' => 'T�n th? lo?i kh�ng du?c d? tr?ng',
            'txtCateName.unique' => 'T�n th? lo?i n�y d� t?n t?i'
        ];
    }
}
