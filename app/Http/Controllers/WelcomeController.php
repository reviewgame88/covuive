<?php
namespace App\Http\Controllers;

use DB,Requests,Mail,Cart;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as sm_request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Hash;
use App\User;
use App\BuyCard;
use App\Http\Requests\UserRequest;
use App\product_atr_cate;
use App\product_atr;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;

class WelcomeController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //protected $request;

    public function __construct(Request $request) {
        //$this->request = $request;
    }
    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        $product_atr_cate = product_atr_cate::select('id','name')->get()->toArray(); 
        foreach($product_atr_cate as $key=>$value)
        {
            $product_atr_cate[$key]['product_atr_list'] = array();
            $product_atr = product_atr::select('id','name')->where('product_atr_cate_id','=',$value['id'])->get()->toArray(); 
            if(!empty($product_atr))
            $product_atr_cate[$key]['product_atr_list'] = $product_atr;
        }
        //dd($product_atr_cate); exit();
        $all_product = DB::table('products')->where('status','=','1')->orderBy('id','DESC')->get();
        $lastest_product = DB::table('products')->where('status','=','1')->orderBy('id','DESC')->skip(0)->take(4)->get();
        $special_product = DB::table('products')->where('status','=','1')->orderBy('sale_off','DESC')->skip(0)->take(4)->get();
        
        $all_product = DB::table('products')->where('status','=','1')->paginate(12);
        //dd($all_product); exit();
        
        return view('user.pages.home',compact('lastest_product','special_product','product_atr_cate','all_product'));
    }
    
    function postSearch(sm_request $request)
    {
        $from_price = (!empty(Request::input('from_price')) ? Request::input('from_price') : 0);
        $to_price = (!empty(Request::input('to_price')) ? Request::input('to_price') : 999999999);
        $count_search = 0;
        
        $check_search_price = false;
        $check_search_golf = false;
        
        if(!empty(Request::input('from_price')) || !empty(Request::input('to_price')))
        {
           $count_search++; 
           $check_search_price = true;
        }
        
        if($to_price<$from_price)
        {
            $temp = $to_price;
            $to_price = $from_price;
            $from_price = $temp;
        }
        
        $rank = Request::input('rank');
        if(!empty(Request::input('rank')))
        {
           $count_search++; 
        }
        
        $gold = (!empty(Request::input('gold')) ? Request::input('gold') : 0);
        
        if(!empty(Request::input('gold')))
        {
           $count_search++; 
           $check_search_golf = true;
        }
        
        $arr_product_detail = (!empty(Request::input('product_atr_list')) ? Request::input('product_atr_list') : array());
        
        if(!empty(Request::input('product_atr_list')))
        {
           $count_search++; 
        }
        
        $result = DB::table('products')
                            ->where('status','=','1')
                             ->where('id','=','2')
                            ->where(function ($query) use ($from_price,$to_price){
                                $query->whereBetween('price', [$from_price, $to_price])
                                      ->orWhereBetween('price_atm', [$from_price, $to_price]);
                            })
                            ->orderBy('price_atm','DESC')->get();
        
        $msg = 0;   
        $check_true_price = false;                 
        if(empty($result))
        {
            $result = DB::table('products')
                            ->where('status','=','1')
                            ->where(function ($query) use ($from_price,$to_price){
                                $query->whereBetween('price', [$from_price-100000, $to_price+100000])
                                      ->orWhereBetween('price_atm', [$from_price-100000, $to_price+100000]);
                            })
                            ->orderBy('price_atm','DESC')->get();
                            
        }
        else
        {
            $check_true_price = true;
        }
        
        if(!empty($result))
        {              
            foreach($result as $k=>$v)
            {
                if($check_true_price && $check_search_price)
                {
                    $check_acc = 1;
                }
                else
                {
                    $check_acc = 0;
                }               
                if(!empty($arr_product_detail))
                {
                    $atr_product = DB::table('product_detail')
                                    ->where('product_id','=',$v->id)
                                    ->get();
                    $count = 0;                
                    foreach($arr_product_detail as $key=>$value)
                    {
                        foreach($atr_product as $atr_k => $val_k)
                        {
                            if($value==($val_k->product_atr_id))
                            {
                                $count++;
                                break;
                            }
                        }
                    }                                         
                    if(($count==0) || ($count>0 && $count!=count($arr_product_detail)))
                    {
                    }
                    elseif($count==count($arr_product_detail))
                    {
                        $check_acc++;
                    }                   
                }
                
                if($v->rank>=$rank)
                {
                    $check_acc++;
                    if($v->gold>=$gold)
                    {
                        if($check_search_golf)
                        {
                            $check_acc++;
                        }
                    }
                    else
                    {
                        
                    }
                }
                else
                {
                    if($v->gold>=$gold)
                    {
                        if($check_search_golf)
                        {
                            $check_acc++;
                        }
                    }
                    else
                    {
                        
                    }
                }
                if($check_acc>=$count_search)
                {
                    
                    $msg = 1;
                }
            } 
        }
        
        if($msg==0)
        {
            $result = DB::table('products')
                            ->where('status','=','1')
                            ->orderBy('price_atm','DESC')->get();
                            
            if(!empty($result))
            {   
                foreach($result as $k=>$v)
                {
                    $check_acc = 0;
                    if(!empty($arr_product_detail))
                    {
                        $atr_product = DB::table('product_detail')
                                        ->where('product_id','=',$k)
                                        ->get();
                        $count = 0;                
                        foreach($arr_product_detail as $key=>$value)
                        {
                            foreach($atr_product as $atr_k => $val_k)
                            {
                                if($value==($val_k->product_atr_id))
                                {
                                    $count++;
                                    break;
                                }
                            }
                        } 
                        if(($count==0) || ($count>0 && $count!=count($arr_product_detail)))
                        {
                        }
                        elseif($count==count($arr_product_detail))
                        {
                            $check_acc++;
                        }                   
                    }
                    
                    if($v->rank>=$rank)
                    {
                        $check_acc++;
                        if($v->gold>=$gold)
                        {
                            $check_acc++;
                        }
                        else
                        {
                            
                        }
                    }
                    else
                    {
                        if($v->gold>=$gold)
                        {
                            $check_acc++;
                        }
                        else
                        {
                            
                        }
                    }
                    
                    if($check_acc==0)
                    {
                        unset($result[$k]);
                    }
                } 
            }               
        }
        
        $product_atr_cate = product_atr_cate::select('id','name')->get()->toArray(); 
        foreach($product_atr_cate as $key=>$value)
        {
            $product_atr_cate[$key]['product_atr_list'] = array();
            $product_atr = product_atr::select('id','name')->where('product_atr_cate_id','=',$value['id'])->get()->toArray(); 
            if(!empty($product_atr))
            $product_atr_cate[$key]['product_atr_list'] = $product_atr;
        }
        
        
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        //dd($currentPage);
        // Create a new Laravel collection from the array data
        $itemCollection = collect($result);
 
        // Define how many items we want to be visible in each page
        $perPage = 12;
 
        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
 
        // Create our paginator and pass it to the view
        $result= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);
 
        
        $result->setPath('search');
        //dd($msg);
        
        $lastest_product = DB::table('products')->where('status','=','1')->orderBy('id','DESC')->skip(0)->take(4)->get();
        
        return view('user.pages.search',compact('result','msg','product_atr_cate','result','lastest_product','request'));
    }
    
    public function getRegister()
    {
        if(Auth::check()){
            return redirect('/');
        }
        else{
            return view('user.pages.register');
        }
    }
    
    public function postRegister(UserRequest $userRequest)
    {
        if(Auth::check()){
            return redirect('/');
        }
        else{
            $userData = new User;
            $userData->name = $userRequest->txtUser;
            $userData->email = $userRequest->txtEmail;
            $userData->password = hash::make($userRequest->txtPass);
            $userData->level = 2;
            $userData->remember_token = $userRequest->_token;
            $userData->status = 1;
            $userData->save();
            return redirect()->route('getDangnhap')->with(['flash-level'=>'success','flash-message'=>'Add user successfully']);
        }
    }
    
    public function getLogin()
    {
        if(Auth::check()){
            return redirect('/');
        }
        else{
            return view('user.pages.login');
        }
    }
    
    public function postLogin(LoginRequest $loginRequest)
    {
        if(Auth::check()){
            return redirect('/');
        }
        else{
            $login = array(
              'email'  => $loginRequest->email,
              'password' => $loginRequest->password,
               'level' => 2
            );
            //dd(hash::make("anhemta")); return;
            if(Auth::attempt($login)){
                if ($loginRequest->game_type == "chinese_chess") {
                    return view('user.pages.chinese_chess_online');
                }
                else
                {
                    return redirect('/');
                }               
            }
            else{
                return redirect()->back()->with(['flash-level'=>'success','flash-message'=>'Tài khoản hoặc mật khẩu không đúng!']);
            }
        }
    }
    
    public function logout()
    {
        if(!Auth::check()){
            return redirect('/');
        }
        else{
            Auth::logout();
            return redirect('/');
        }
    }
    
    public function show_chinese_chess()
    {
        if(Auth::check()){
            return view('user.pages.chinese_chess_online');
        }
        else{
            return view('user.pages.login',['game_type'=>'chinese_chess']);
        }   
    }

    public function loaisanpham($id){
        $product_atr_cate = product_atr_cate::select('id','name')->where('cate_id','=',$id)->get()->toArray(); 
        foreach($product_atr_cate as $key=>$value)
        {
            $product_atr_cate[$key]['product_atr_list'] = array();
            $product_atr = product_atr::select('id','name')->where('product_atr_cate_id','=',$value['id'])->get()->toArray(); 
            if(!empty($product_atr))
            $product_atr_cate[$key]['product_atr_list'] = $product_atr;
        }
        //dd($product_atr_cate); exit();
        $all_product = DB::table('products')->where('status','=','1')->where('cate_id','=',$id)->orderBy('id','DESC')->get();
        $lastest_product = DB::table('products')->where('status','=','1')->where('cate_id','=',$id)->orderBy('id','DESC')->skip(0)->take(4)->get();
        $special_product = DB::table('products')->where('status','=','1')->where('cate_id','=',$id)->orderBy('sale_off','DESC')->skip(0)->take(4)->get();
        
        $all_product = DB::table('products')->where('status','=','1')->where('cate_id','=',$id)->paginate(12);
        //dd($all_product); exit();
        
        return view('user.pages.category',compact('lastest_product','special_product','product_atr_cate','all_product'));
    }

    public function sanpham($id){

        $product_images = DB::table('product_images')->where('product_id',$id)->get();
        $product = DB::table('products')->where('id',$id)->first();
        $special_product = DB::table('products')->where('status','=','1')->where('cate_id','=',$id)->orderBy('sale_off','DESC')->skip(0)->take(4)->get();
        
        $prd_price = $product->price;
        $prd_price_atm = $product->price;
        
        $same_product = DB::table('products')
                            ->where('status','=','1')
                            ->where('id','!=',$id)
                            ->where(function ($query) use ($prd_price, $prd_price_atm){
                                $query->whereBetween('price', [$prd_price-100000, $prd_price+100000])
                                      ->orWhereBetween('price_atm', [$prd_price_atm-100000, $prd_price_atm+100000]);
                            })
                            ->orderBy('price_atm','DESC')->skip(0)->take(12)->get();
        
        return view('user.pages.product',compact('product','product_images','special_product','same_product'));
    }

    public  function getLienHe(){
        return view('user.pages.contact');
    }

    public function postLienHe(Request $request){
        $data = ['hoten'=>Request::input('name'),'email'=>Request::input('email'),'noidung'=>Request::input('message')];
        Mail::send('emails.mailto',$data,function($msg){
            $msg->from("thoidaimoimb@gmail.com");
            $msg->to("thoidaimoimb@gmail.com")->subject("Phản hồi khách hàng");
        });
        return redirect('/')->with(['message'=>'ok']);
    }

    public function muaHang($id){
        //$product_buy = DB::table('products')->where('id',$id)->first();
//        Cart::add(array('id'=>$product_buy->id, 'name'=>$product_buy->name, 'qty'=> 1, 'price'=>$product_buy->price*(1-$product_buy->sale_off/100), 'options'=>array('img'=>$product_buy->image,'cate_id'=>$product_buy->cate_id,'sale_off'=>$product_buy->sale_off)));
//        return redirect()->route('giohang');
        if(!Auth::check()){
            return redirect()->route('getDangnhap');
        }
        else
        {
            
        }
    }

    public function gioHang(){

        //Cart::destroy();
        $content = Cart::content();
        $total = Cart::total();
        return view('user.pages.shopping-cart',compact('content','total'));
    }

    public function xoaSanPham($id){
        if(Request::ajax()){
        Cart::remove($id);
        $total = Cart::total();
        return number_format($total,0,'.',',')."VNĐ";
        }
    }

    public function capNhatSp($id){
        if(Request::ajax()){
            $qty = Request::get('qty');
            $single_total = Request::get('single_total');
            Cart::update($id, $qty);
            $total = Cart::total();
            $single_total*=$qty;
            return ["total"=>number_format($total,0,'.',',')."VNĐ","single_total"=>number_format($single_total,0,'.',',')."VNĐ"];
        }
    }
    
    public function getBuyAcc($id)
    {
        if(Auth::check()){
            if(Request::ajax()){
                $user_id =  Auth::user()->id;
                $product = DB::table('products')->where('id',$id)->where('status','=','1')->first();
                $user_info = DB::table('users')->where('id',$user_id)->where('status','=','1')->first();
                
                $prd_price = $product->price;
                $current_money = $user_info->current_money;
                
                $msg = "";
                if($product->status==1)
                {                
                    if($current_money>=$prd_price)
                    {
                        $current_money -= $prd_price;
                        
                        DB::table('users')->where('id',$user_id)->update(array(
                                     'current_money'=>$current_money,
                        ));

                        DB::table('products')->where('id',$id)->update(array(
                                     'status'=>0,
                                     'user_id'=>$user_id,
                                     'time_buy'=>time()                                                                          
                        ));                        
                                                
                        $msg = 1;
                    }
                    else
                    {
                        $msg = 0;
                    }
                }
                elseif($product->status==0)
                {
                    $msg = 2;
                                    
                }                                                
            }
        }
        else
        {   
           $msg = 3; 
        }
        return ['msg'=>$msg];
    }
    
    function getNapThe()
    {
        if(!Auth::check()){
            return redirect()->route('getDangnhap');
        }
        else{
            return view('user.pages.buycard');
        }       
    }
    
    function postNapThe(BuyCard $buycard)
    {
        $rules = ['captcha' => 'required|captcha'];
        $validator = Validator::make(Request::all(), $rules);
        if ($validator->fails())
        {
            return redirect()->back()->with(['flash-level'=>'danger','flash-message'=>'Sai mã bảo mật!']);
        }
        else
        {
            $buyCa = new BuyCard;
            $buyCa->user_id = Auth::user()->id;
            $buyCa->card_type_id = Request::input('card_type_id');
            $buyCa->amount = Request::input('price_guest');
            $buyCa->seri = Request::input('seri');
            $buyCa->pass_card = Request::input('pin');
            $buyCa->status = 2;
            $buyCa->save();
            return redirect()->back()->with(['flash-level'=>'success','flash-message'=>'Nạp thẻ thành công ! Vui lòng chờ để chúng tôi kiểm tra lại thông tin thẻ.']);
        }   
        exit();    
    }
    
    function getLichSu()
    {
        if(!Auth::check()){
            return redirect('/');
        }
        else{
            $user_id =  Auth::user()->id;
            $account_info = DB::table('products')->where('user_id',$user_id)->orderBy('created_at','DESC')->get(['id','name','content','time_buy','alias']);

            return view('user.pages.history',compact('account_info'));
        }
    }
    
    function getCheckNapThe()
    {
        if(!Auth::check()){
            return redirect('/');
        }
        else{
             if(Request::ajax()){
                $user_id =  Auth::user()->id;
                $buy_card = DB::table('buy_cards')->where('user_id',$user_id)->orderBy('created_at','DESC')->get();
                return $buy_card;                                              
            }
        }
    }

}