<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\product_atr_cate;
use App\Http\Requests\ProductAtributeCateRequest;
use App\cate;

class ProductAtributeCate extends Controller
{
    public function getList(){
        $productInfo = product_atr_cate::select('id','name','cate_id','status')->orderBy('id','DESC')->get()->toArray();
        return view('admin.product_atr_cate.list',compact('productInfo'));
    }
    public function getAdd(){
        $parent = cate::select('id','name','parent_id')->get()->toArray();
        return view('admin.product_atr_cate.add',compact('parent'));
    }

    public function postAdd(ProductAtributeCateRequest $ProductAtributeCateRequest){
        $addCate = new product_atr_cate;
        $addCate->name = $ProductAtributeCateRequest->txtCateName;
        $addCate->alias = changeTitle($ProductAtributeCateRequest->txtCateName);
        $addCate->cate_id = $ProductAtributeCateRequest->cateParent;
        $addCate->status = $ProductAtributeCateRequest->rdoStatus;
        $addCate->save();
        return redirect()->route('admin.product_atr_cate.getList')->with(['flash-message'=>'Add product atribute category successfully!!!','flash-level'=>'success']);
    }

    public function getDelete($id){
        $parent = cate::where('cate_id',$id)->count();
        if($parent==0){
            $cate = cate::find($id);
            $cate->delete($id);
            return redirect()->route('admin.product_atr_cate.getList')->with(['flash-message'=>'Deleted successfully!!!','flash-level'=>'info']);  
        }
        else{
            echo("<script type='text/javascript'>
                    alert('You cannot delete this category');
                    window.location = '".route('admin.cate.getList')."'
                </script>");
        }
        
    }
    public function getEdit($id){
        $dataEdit = product_atr_cate::findOrFail($id)->toArray();
        $parent = cate::select('id','name','parent_id')->get()->toArray();
        return view('admin.product_atr_cate.edit',compact('parent','dataEdit','id'));
    }
    public function postEdit(Request $Request,$id){
        $editCate = product_atr_cate::findOrFail($id); 
        $editCate->name = $Request->txtCateName;
        $editCate->alias = changeTitle($Request->txtCateName);
        $editCate->cate_id = $Request->cateParent;
        $editCate->status = $Request->rdoStatus;
        $editCate->save();
        return redirect()->route('admin.product_atr_cate.getList')->with(['flash-message'=>'Edit product successfully!!!','flash-level'=>'success']);   
    }
}
