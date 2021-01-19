<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Hash;
use Illuminate\Support\Facades\Input;
use Validator;
use Request;
class UserController extends Controller
{
    public function getList(){
        $data = User::all()->toArray();
        return view('admin.user.list',compact('data'));
    }

    public function getAdd(){
        return view('admin.user.add');
    }

    public function postAdd(UserRequest $userRequest){
        $userData = new User;
        $userData->name = $userRequest->txtUser;
        $userData->email = $userRequest->txtEmail;
        $userData->password = hash::make($userRequest->txtPass);
        $userData->level = $userRequest->rdoLevel;
        $userData->remember_token = $userRequest->_token;
        $userData->status = 1;
        $userData->save();
        return redirect()->route('admin.user.getList')->with(['flash-level'=>'success','flash-message'=>'Add user successfully']);
    }

    public function getDelete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.user.getList')->with(['flash-level'=>'success','flash-message'=>'Delete user successfully']);
    }

    public function getEdit($id){
        $user = User::findOrFail($id)->toArray();

        return view('admin.user.edit',compact(['user','id']));
    }

    public function postEdit($id, Request $request){
        $user = User::findOrFail($id);
        $vld = Validator::make(Request::all(),
            [
                'txtPass' =>'min:6|max:15',
                'txtRePass' => 'same:txtPass',
                'txtEmail' =>'unique:users,email,'.$id
            ],
            [
                'txtPass.min'=>'Your password is less than 6 characters',
                'txtPass.max'=>'Your password is big than 15 characters',
                'txtRePass.same' => 'RePass is not same above',
                'txtEmail' => 'This email already exists'
            ]
        );
        if($vld->fails()){
            return redirect()->back()->withErrors($vld->errors());
        }
        
        $user->email = Request::input('txtEmail');
        if(!empty(Input::get('txtPass'))){
            $user->password = hash::make(Request::input('txtPass'));
        }
        $user->level = Request::input('rdoLevel');
        $user->save();
        return redirect()->route('admin.user.getList')->with(['flash-level'=>'success','flash-message'=>'Edit user successfully']);
    }
}
