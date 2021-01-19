<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CateRequest extends Request
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
            'txtCateName'=>'required|unique:cates,name',
        ];
    }

    public function messages(){
        return [
            'txtCateName.required' => 'Tên thể loại không được để trống',
            'txtCateName.unique' => 'Tên thể loại này đã tồn tại'
        ];
    }
}
