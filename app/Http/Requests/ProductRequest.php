<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
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
            'cateParent' => 'required',
            'txtPrice'=> 'required',
            'fImages'=>'required|image'
        ];
    }
    public function messages(){
        return [
            'cateParent.required'=>'Vui lòng chọn loại sản phẩm',
            'fImages.required' =>'Vui lòng nhập ảnh sản phẩm',
            'fImages.image' => 'File này không phải định dạng ảnh'
        ];
    }
}
