<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductAtributeRequest extends Request
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
            'atrCateParent' => 'required',
            'txtName' => 'required|unique:product_atr,name'
        ];
    }
    
    public function messages(){
        return [
            'atrCateParent.required'=>'Vui l�ng ch?n lo?i thu?c t�nh',
            'txtName.required' =>'Vui l�ng nh?p t�n thu?c t�nh',
            'txtName.unique' =>'T�n thu?c t�nh n�y d� t?n t?i'
        ];
    }
}
