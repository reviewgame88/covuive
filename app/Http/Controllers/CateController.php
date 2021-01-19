<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CateRequest;
use App\cate;

class CateController extends Controller
{
    public function getList(){
        $productInfo = cate::select('id','name','parent_id','status')->orderBy('id','DESC')->get()->toArray();
        return view('admin.cate.list',compact('productInfo'));
    }
    public function getAdd(){
        $parent = cate::select('id','name','parent_id')->get()->toArray();
        return view('admin.cate.add',compact('parent'));
    }

    public function postAdd(CateRequest $cateRequest){
        $addCate = new cate;
        $addCate->name = $cateRequest->txtCateName;
        $addCate->alias = changeTitle($cateRequest->txtCateName);
        $addCate->order = $cateRequest->txtOrder;
        $addCate->parent_id = $cateRequest->cateParent;
        $addCate->keywords = $cateRequest->txtKeyword;
        $addCate->description = $cateRequest->txtDescript;
        $addCate->status = $cateRequest->rdoStatus;
        $addCate->save();
        return redirect()->route('admin.cate.getList')->with(['flash-message'=>'Add product successfully!!!','flash-level'=>'success']);
    }

    public function getDelete($id){
        $parent = cate::where('parent_id',$id)->count();
        if($parent==0){
            $cate = cate::find($id);
            $cate->delete($id);
            return redirect()->route('admin.cate.getList')->with(['flash-message'=>'Deleted successfully!!!','flash-level'=>'info']);  
        }
        else{
            echo("<script type='text/javascript'>
                    alert('You cannot delete this category');
                    window.location = '".route('admin.cate.getList')."'
                </script>");
        }
        
    }
    public function getEdit($id){
        $dataEdit = cate::findOrFail($id)->toArray();
        $parent = cate::select('id','name','parent_id')->get()->toArray();
        return view('admin.cate.edit',compact('parent','dataEdit','id'));
    }
    public function postEdit(Request $Request,$id){
        $editCate = cate::findOrFail($id); 
        $editCate->name = $Request->txtCateName;
        $editCate->alias = changeTitle($Request->txtCateName);
        $editCate->order = $Request->txtOrder;
        $editCate->parent_id = $Request->cateParent;
        $editCate->keywords = $Request->txtKeyword;
        $editCate->description = $Request->txtDescript;
        $editCate->status = $Request->rdoStatus;
        $editCate->save();
        return redirect()->route('admin.cate.getList')->with(['flash-message'=>'Edit product successfully!!!','flash-level'=>'success']);   
    }
}
