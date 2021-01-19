@extends('user.master')
@section('description','Home page')
@section('slider')
    @include('user.blocks.slider')
@endsection
@section('otherdetail')
    @include('user.blocks.otherdetail')
@endsection
@section('search')
<section id="search" class="row mt40">
    <div class="container">
        <div id="mySidenav" class="sidenav" style="z-index: 9999;">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <form action="{!! route('search') !!}" method="POST">
                {!! csrf_field() !!}    
                <div class="form-group">
                    <label style="color: white; font-weight: bold;">Khoảng giá</label>
                    <input class="form-control" type="number" name="from_price" style="width: 40%; float: left; padding: 0px;" value="{!! old('from_price') !!}" autocomplete="off"/>
                    <span style="display: block; width: 10%; color: white; float: left; text-align: center; padding: 0px;">-</span>
                    <input class="form-control" type="number" name="to_price" style="width: 40%; float: left; padding: 0px;" value="{!! old('to_price') !!}" autocomplete="off"/>
                </div>
                <div class="form-group" style="clear: both;">
                    <label style="color: white; font-weight: bold;">Khung rank</label>
                    <select name="rank" class="form-control">
                        <option @if(old('rank')=='') selected @endif value="">--Chọn rank--</option> 
                        <option @if(old('rank')==1) selected @endif value="1">Đồng</option>    
                        <option @if(old('rank')==2) selected @endif value="2">Bạc</option>   
                        <option @if(old('rank')==3) selected @endif value="3">Vàng</option>   
                        <option @if(old('rank')==4) selected @endif value="4">Kim Cương</option>  
                        <option @if(old('rank')==5) selected @endif value="5">Cao Thủ</option>       
                        <option @if(old('rank')==6) selected @endif value="6">Thách đấu</option>               
                    </select>
                </div>
                <div class="form-group" style="margin-top: 10px;">
                    <label style="color: white; font-weight: bold;">Vàng tối thiểu</label>
                    <input class="form-control" type="number" name="gold" style="width: 50%;" value="{!! old('gold') !!}" autocomplete="off"/>
                </div>
                 @foreach($product_atr_cate as $key=> $value)
                    <h4 style="color: white;">{{ $value['name'] }} 
                        <span class="fas fa-angle-down pull-right" onclick="$(this).parent().next().toggle();" style="color: white; font-size: 15px; margin-top: 8px; margin-left: 10px; margin-right: 10px; cursor: pointer;"></span> 
                        <span class="fas icon-remove pull-right" onclick="resetChild(this);" style="color: white; font-size: 15px;margin-top: 8px; cursor: pointer;"></span>
                    </h4>
                    <div style="width: 100%; float:left; margin-bottom: 20px;">
                    @foreach($value['product_atr_list'] as $k=>$v)
                        <div style="float: left; width:49%;">
                            <label style="cursor: pointer; color: white;"><input name="product_atr_list[]" type="checkbox" value="{{ $v['id'] }}"  @if(is_array(old('product_atr_list')) && in_array($v['id'], old('product_atr_list'))) checked @endif /> {{ $v['name'] }}</label>
                        </div>    
                    @endforeach
                    </div>
                 @endforeach
                 <div class="form-group" style="text-align: center;">
                     <button type="submit" class="btn-sm btn-success">Tìm kiếm</button>
                     <button type="reset" onclick="if(xacnhanxoa('Bạn có chắc chắn không?')) resetSearch(this);" class="btn-sm btn-danger" style="margin-left: 20px;">Reset</button>
                 </div>
             </form>
        </div>
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Tìm kiếm</span>
    </div>
</section>
@endsection
@section('content')
<a href="{!! route('chineseChessOnline') !!}" class="btn btn-orange">Chess Online</a>
<section id="featured" class="row mt40">
    <div class="container">
        <h1 class="heading1"><span class="maintext">Tài khoản Liên Quân</span></h1>
        <ul class="thumbnails">
            @foreach($all_product as $all_product_item)
            <li class="span3">
                <a  style="min-height: 50px;" class="prdocutname" href="product.html">{!! $all_product_item->name !!}</a>
                <div class="thumbnail">
                    <span class="sale tooltip-test">Sale</span>
                    <a href="{!! URL('/san-pham',[$all_product_item->id,$all_product_item->alias]) !!}"><img alt="{!! $all_product_item->alias !!}" src="{!! asset('resources/upload/'.$all_product_item->image) !!}"></a>
                    <div class="pricetag">
                        <span class="spiral"></span><a href="{!! URL('/san-pham',[$all_product_item->id,$all_product_item->alias]) !!}" class="productcart">Chi tiết</a>
                        <div class="price">
                            <div style="font-size: 13px; color:#ff0000;" class="pricenew"><span style="color: blue; font-weight: bold; display: block; float:left; text-align: left; width: 35px;">Card</span> {!! number_format($all_product_item->price*(1-$all_product_item->sale_off/100),'0','.',',') !!} VNĐ</div>
                            <div class=""><span style="color: blue; font-weight: bold; display: block; float:left; text-align: left; width: 35px;">ATM</span><span style="color: red; font-weight: bold;">{!! number_format($all_product_item->price_atm*(1-$all_product_item->sale_off/100),'0','.',',') !!} VNĐ</span></div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <!--Pagination-->
         <div class="pagination" >
             {!! $all_product->render() !!}
         </div>
    </div>
</section>

<section id="featured" class="row mt40">
    <div class="container">
        <h1 class="heading1"><span class="maintext">Sản phẩm đặc biệt</span></h1>
        <ul class="thumbnails">
            @foreach($lastest_product as $lastest_prd_item)
            <li class="span3">
                <a  style="min-height: 50px;" class="prdocutname" href="product.html">{!! $lastest_prd_item->name !!}</a>
                <div class="thumbnail">
                    <span class="sale tooltip-test">Sale</span>
                    <a href="{!! URL('/san-pham',[$lastest_prd_item->id,$lastest_prd_item->alias]) !!}"><img alt="{!! $lastest_prd_item->alias !!}" src="{!! asset('resources/upload/'.$lastest_prd_item->image) !!}"></a>
                    <div class="pricetag">
                        <span class="spiral"></span><a href="{!! URL('/san-pham',[$lastest_prd_item->id,$lastest_prd_item->alias]) !!}" class="productcart">Chi tiết</a>
                        <div class="price">
                            <div style="font-size: 13px; color:#ff0000;" class="pricenew"><span style="color: blue; font-weight: bold; display: block; float:left; text-align: left; width: 35px;">Card</span> {!! number_format($lastest_prd_item->price*(1-$lastest_prd_item->sale_off/100),'0','.',',') !!} VNĐ</div>
                            <div class=""><span style="color: blue; font-weight: bold; display: block; float:left; text-align: left; width: 35px;">ATM</span><span style="color: red; font-weight: bold;">{!! number_format($lastest_prd_item->price_atm*(1-$lastest_prd_item->sale_off/100),'0','.',',') !!} VNĐ</span></div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>

<!-- Latest Product-->
<section id="latest" class="row">
    <div class="container">
        <h1 class="heading1"><span class="maintext">Sản phẩm mới nhất</span></h1>
        <ul class="thumbnails">
            @foreach($special_product as $special_product_item)
            <li class="span3">
                <a  style="min-height: 50px;" class="prdocutname" href="product.html">{!! $special_product_item->name !!}</a>
                <div class="thumbnail">
                    <a href="{!! URL('/san-pham',[$special_product_item->id,$special_product_item->alias]) !!}"><img alt="{!! $special_product_item->alias !!}" src="{!! asset('resources/upload/'.$special_product_item->image) !!}"></a>
                    <div class="pricetag">
                        <span class="spiral"></span><a href="{!! URL('/san-pham',[$special_product_item->id,$special_product_item->alias]) !!}" class="productcart">Chi tiết</a>
                        <div class="price">
                            <div style="font-size: 13px; color:#ff0000;" class="pricenew"><span style="color: blue; font-weight: bold; display: block; float:left; text-align: left; width: 35px;">Card</span> {!! number_format($special_product_item->price*(1-$special_product_item->sale_off/100),'0','.',',') !!} VNĐ</div>
                            <div class=""><span style="color: blue; font-weight: bold; display: block; float:left; text-align: left; width: 35px;">ATM</span><span style="color: red; font-weight: bold;">{!! number_format($special_product_item->price_atm*(1-$special_product_item->sale_off/100),'0','.',',') !!} VNĐ</span></div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>
@endsection
