<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\cate;
use App\product_atr_cate;
use App\product_atr;
use App\product_detail;
use App\Http\Requests\ProductRequest;
use App\product;
use App\product_image;
use Illuminate\Support\Facades\Validator;
use Input,File;
use Request;
use Auth;

class ProductController extends Controller
{
    public function getList(){
    	
    	$product = product::select('id','name','price','created_at','status','cate_id')->get()->toArray();
    	return view('admin.product.list',compact('product'));
    }

    public function getAdd(){
    	$parent = Cate::select('id','name','parent_id')->get()->toArray();
        $product_atr_cate = product_atr_cate::select('id','name')->get()->toArray(); 
        foreach($product_atr_cate as $key=>$value)
        {
            $product_atr_cate[$key]['product_atr_list'] = array();
            $product_atr = product_atr::select('id','name')->where('product_atr_cate_id','=',$value['id'])->get()->toArray(); 
            if(!empty($product_atr))
            $product_atr_cate[$key]['product_atr_list'] = $product_atr;
        }
        //dd($product_atr_cate); exit();
    	return view('admin.product.add',compact('parent','product_atr_cate'));
    }
    public function postAdd(ProductRequest $ProductRequest){
        //dd($ProductRequest); exit();
    	$file_name = convertImgName($ProductRequest->file('fImages')->getClientOriginalName());
    	$product = new product;
    	$product->name = "";
    	$product->alias = changeTitle($ProductRequest->txtName);
    	$product->price = $ProductRequest->txtPrice;
        $product->price_atm = $ProductRequest->txtPriceAtm;
        $product->gold = $ProductRequest->txtGold;
        $product->qh = $ProductRequest->txtQh;
        $product->rank = $ProductRequest->txtRank;
        $product->sell = 0;
		$product->sale_off = $ProductRequest->txtSaleOff;
    	$product->intro = $ProductRequest->txtIntro;
    	$product->content = $ProductRequest->txtContent;
    	$product->image = $file_name;
    	$product->keywords = $ProductRequest->txtKeyword;
    	$product->description = $ProductRequest->txtDescription;
    	$product->cate_id = $ProductRequest->cateParent;
    	$product->status = $ProductRequest->rdoStatus;
    	$ProductRequest->file('fImages')->move('resources/upload/',$file_name);
    	$product->save();

    	$productID = $product->id;
        
        $product->name = "#".str_pad($productID,5,"0",STR_PAD_LEFT);
        $product->save();
        
    	if(Input::hasFile('imageGroup')){
    		foreach (Input::file('imageGroup') as $file) {
    			$productImage = new product_image;
    			if(isset($file)){
    			$imgName = convertImgName($file->getClientOriginalName());
    			$productImage->images = $imgName;
    			$productImage->product_id = $productID;
    			$file->move('resources/upload/details/',$imgName);
    			$productImage->save();
    		}
    		}
    	}
        
        $product_atr_list = $ProductRequest->product_atr_list;
        
        $dataSet = [];
        foreach($product_atr_list as $key=>$value)
        {
            $dataSet[] = [
                'product_id'  => $productID,
                'product_atr_id'  => $value,
            ];
        }
        DB::table('product_detail')->insert($dataSet);
        
    	return redirect()->route('admin.product.getList')->with(['flash-level'=>'success','flash-message'=>'Add Product Successfully!']);
    }

    public function getDelete($id){
    	$productImage = product::findOrFail($id)->product_image;
    	foreach($productImage as $value){
    		File::delete('resources/upload/details/'.$value->images);	
    	}
    	$product = product::findOrFail($id);
    	File::delete('resources/upload/'.$product->image);
    	$product->delete($id);
    	return redirect()->route('admin.product.getList')->with(['flash-level'=>'success','flash-message'=>'Delete Product Successfully!']);
    }

    public function getEdit($id){
    	$data = Cate::select('id','name','parent_id')->get()->toArray();
        
    	$product = product::findOrFail($id)->toArray();
    	$product_image = product::findOrFail($id)->product_image;
        
        
        
        $product_detail = product_detail::where('product_id','=',$id)->get()->toArray();
        //dd($product_atr); exit();
        $product_atr_cate = product_atr_cate::select('id','name')->get()->toArray(); 
        
        foreach($product_atr_cate as $key=>$value)
        {
            $product_atr_cate[$key]['product_atr_list'] = array();
            $product_atr = product_atr::select('id','name')->where('product_atr_cate_id','=',$value['id'])->get()->toArray(); 
            
            if(!empty($product_atr))
            {
                foreach($product_atr as $k=>$v)
                {
                    $product_atr[$k]['select'] = 0;
                    foreach($product_detail as $k1 => $v1)
                    {
                        if($v1['product_atr_id']==$v['id'])
                        {
                            $product_atr[$k]['select'] = 1;
                        }
                    }
                }
            }
            $product_atr_cate[$key]['product_atr_list'] = $product_atr;
        }
        
    	return view('admin.product.edit',compact('data','product_atr_cate','product','product_image'));
    }

    public function postEdit(Request $Request,$id){

		if(Input::hasFile('fEditDetail')){
			$arrImg = Request::file('fEditDetail');
			foreach($arrImg as $val){
				if(isset($val)){
				$imgDetailName = convertImgName($val->getClientOriginalName());
				$imgProductDetail = new product_image;
				$imgProductDetail->images = $imgDetailName;
				$imgProductDetail->product_id = $id;
				$val->move('resources/upload/details/',$imgDetailName);
				$imgProductDetail->save();
				}
			}
		}
		$vld = Validator::make(Request::all(),
			[
				'fImage' => 'image'
			],
			[
				'fImage.image'=>'Đây không phải định dạng ảnh'
			]
			);
		if($vld->fails()){
			return redirect()->back()->withErrors($vld->errors());
		}
		$product_edit = product::findOrFail($id);

		$product_edit->name = "#".str_pad($id,5,"0",STR_PAD_LEFT);
		$product_edit->alias = changeTitle( Request::input('txtName'));
		$product_edit->cate_id =  Request::input('cateParent');
		$product_edit->price =  Request::input('txtPrice');
        $product_edit->price_atm =  Request::input('txtPriceAtm');
        $product_edit->gold =  Request::input('txtGold');
        $product_edit->qh =  Request::input('txtQh');
        $product_edit->rank = Request::input('txtRank');
		$product_edit->sale_off = Request::input('txtSaleOff');
		$product_edit->intro =  Request::input('txtIntro');
		$product_edit->content =  Request::input('txtContent');
		$product_edit->keywords =  Request::input('txtKeyword');
		$product_edit->description =  Request::input('txtDescription');
		$product_edit->status =  Request::input('rdoStatus');
		$product_edit->user_id = Auth::user()->id;
		if(Input::hasFile('fImage')) {
			$urlImage = 'resources/upload/'.$product_edit->image;
			$ImgName = $product_edit->image;
			if(File::exists($urlImage)){
				File::delete($urlImage);
			}
			$currentImgName = convertImgName(Request::file('fImage')->getClientOriginalName());
			Request::file('fImage')->move('resources/upload/',$currentImgName);
			$product_edit->image = $currentImgName;
		}
		$product_edit->save();
        
        DB::table('product_detail')->where('product_id', '=', $id)->delete();
        
        $product_atr_list = Request::input('product_atr_list');
        if(!empty($product_atr_list))   
        {    
            foreach($product_atr_list as $key=>$value)
            {
                $product_detail = new product_detail;
                $product_detail->product_id = $id;
                $product_detail->product_atr_id = $value;
                $product_detail->save();
            }
        }
        
		return redirect()->route('admin.product.getList')->with(['flash-level'=>'success','flash-message'=>'Edit Product Successfully!']);
    }

    public function getDelImg($id){
    	if(Request::ajax()){
    		$idHinh = (int)Request::get('idHinh');
    		$img_detail = product_image::findOrFail($idHinh);
    		if(!empty($img_detail)){
    			$img = 'resources/upload/details/'.$img_detail->images;
    			if(File::exists($img)){
    				File::delete($img);
    			}
    			$img_detail->delete();
    		}
    		return "ok";
    	}
    }
}
