<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProductAtributeRequest;
use App\Http\Controllers\Controller;
use App\product_atr;
use App\cate;
use App\product_atr_cate;

class ProductAtrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(){
    	
    	$product_atr = DB::table('product_atr')
                    ->join('product_atr_cates', 'product_atr.product_atr_cate_id', '=', 'product_atr_cates.id')
                    ->join('cates', 'product_atr_cates.cate_id', '=', 'cates.id')
                    ->select('product_atr.id', 'product_atr.name as atr_name', 'product_atr.status','product_atr_cates.name','cates.name as cate_name')
                    ->get();   
                     
                    
                    $arrayData = array_map(function($item) {
                        return (array)$item; 
                    }, $product_atr);   
                    $product_atr = $arrayData;         
    	return view('admin.ProductAtribute.list',compact('product_atr'));
    }

    public function getAdd(){
        
        $prd_atr_parent = product_atr_cate::select('id','name','cate_id')->orderBy('cate_id', 'desc')->get()->toArray();
    	return view('admin.ProductAtribute.add',compact('prd_atr_parent'));
    }
    public function postAdd(ProductAtributeRequest $ProductAtrRequest){
    	$product = new product_atr;
    	$product->name = $ProductAtrRequest->txtName;
        $product->product_atr_cate_id = $ProductAtrRequest->atrCateParent;
    	$product->status = $ProductAtrRequest->rdoStatus;
    	$product->save();

    	return redirect()->route('admin.ProductAtribute.getList')->with(['flash-level'=>'success','flash-message'=>'Add Product Atribute Successfully!']);
    }

    public function getDelete($id){
    	$product_atr = product_atr::findOrFail($id);
    	$product_atr->delete($id);
    	return redirect()->route('admin.ProductAtribute.getList')->with(['flash-level'=>'success','flash-message'=>'Delete Product Successfully!']);
    }

    public function getEdit($id){
    	$prd_atr_parent = product_atr_cate::select('id','name','cate_id')->orderBy('cate_id', 'desc')->get()->toArray();
        $product_atr_cate = product_atr_cate::select('id','name','cate_id')->get()->toArray();
    	$product_atr = product_atr::findOrFail($id)->toArray();
    	return view('admin.ProductAtribute.edit',compact('prd_atr_parent','product_atr_cate','product_atr'));
    }

    public function postEdit(Request $Request,$id){
		$vld = Validator::make(Request::all(),
			[
                'atrCateParent' => 'required',
				'txtName' => 'required|unique:products,name,'.$id,
			],
			[
                'atrCateParent.required'=>'Vui lòng ch?n lo?i thu?c tính',
                'txtName.required' =>'Vui lòng nh?p tên thu?c tính',
                'txtName.unique' =>'Tên thu?c tính này dã t?n t?i'
			]
			);
		if($vld->fails()){
			return redirect()->back()->withErrors($vld->errors());
		}
		$product_edit = product_atr::findOrFail($id);

		$product_edit->name = Request::input('txtName');
        $product_edit->product_atr_cate_id =  Request::input('atrCateParent');
		$product_edit->status =  Request::input('rdoStatus');
		$product_edit->save();
		return redirect()->route('admin.ProductAtribute.getList')->with(['flash-level'=>'success','flash-message'=>'Edit Product Successfully!']);
    }
}
