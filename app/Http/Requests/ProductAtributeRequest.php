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
            'atrCateParent.required'=>'Vui lòng ch?n lo?i thu?c tính',
            'txtName.required' =>'Vui lòng nh?p tên thu?c tính',
            'txtName.unique' =>'Tên thu?c tính này dã t?n t?i'
        ];
    }
}
