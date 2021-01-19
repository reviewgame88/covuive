<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'txtUser' => 'required',
            'txtPass' => 'required',
            'txtRePass' => 'required|same:txtPass',
            'txtEmail' => 'required|unique:users,email'
        ];
    }
    public function messages(){
        return [
            'txtUser.required'=>'Họ tên không được để trống!',
            'txtEmail.required' => 'Email không được để trống!',
            'txtEmail.unique' => 'Email này đã tồn tại!',
            'txtPass.required' => 'Mật khẩu không được để trống!',
            'txtRePass.required' => 'Chưa nhập lại mật khẩu!',
            'txtRePass.same' => 'Nhập lại mật mẩu không khớp!',
            
        ];
    }
}
