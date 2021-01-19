<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\BuyCard;


class CheckCard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getList(){
    	
    	$buy_card = DB::table('buy_cards')
                    ->join('users', 'users.id', '=', 'buy_cards.user_id')
                    ->select('buy_cards.id', 'buy_cards.seri', 'buy_cards.pass_card','buy_cards.status','buy_cards.created_at','buy_cards.amount','users.name')
                    ->get();   
                        
    	return view('admin.CheckCard.list',compact('buy_card'));
    }

    public function getAdd(){
        
        $prd_atr_parent = product_atr_cate::select('id','name','cate_id')->orderBy('cate_id', 'desc')->get()->toArray();
    	return view('admin.CheckCard.add',compact('prd_atr_parent'));
    }
    public function postAdd(ProductAtributeRequest $ProductAtrRequest){
    	$product = new product_atr;
    	$product->name = $ProductAtrRequest->txtName;
        $product->product_atr_cate_id = $ProductAtrRequest->atrCateParent;
    	$product->status = $ProductAtrRequest->rdoStatus;
    	$product->save();

    	return redirect()->route('admin.CheckCard.getList')->with(['flash-level'=>'success','flash-message'=>'Add Product Atribute Successfully!']);
    }

    public function getDelete($id){
    	$buy_card = BuyCard::findOrFail($id);
    	$buy_card->delete($id);
    	return redirect()->route('admin.CheckCard.getList')->with(['flash-level'=>'success','flash-message'=>'Delete Product Successfully!']);
    }

    public function getEdit($id){
    	$buy_card = BuyCard::findOrFail($id)->toArray();

    	return view('admin.CheckCard.edit',compact('buy_card'));
    }

    public function postEdit(Request $Request,$id){
		$buy_card = BuyCard::findOrFail($id);
		$buy_card->status =  Request::input('rdoStatus');
		$buy_card->save();
		return redirect()->route('admin.CheckCard.getList')->with(['flash-level'=>'success','flash-message'=>'Edit Product Successfully!']);
    }
}
