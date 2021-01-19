@extends('user.master')
@section('content')
<div id="maincontainer">
  <section id="product">
    <div class="container">      
      <!-- Product Details-->
      <div class="row">
       <!-- Left Image-->
        <div class="span5">
          <ul class="thumbnails mainimage">
            <li class="span5">
              <a  rel="position: 'inside' , showTitle: false, adjustX:-4, adjustY:-4" class="thumbnail cloud-zoom" href="{!! URL('resources/upload/'.$product->image) !!}">
                <img src="{!! URL('resources/upload/'.$product->image) !!}" alt="{!! $product->alias !!}" title="{!! $product->alias !!}">
              </a>
            </li>
            @foreach($product_images as $prd_img)
              <li class="span5">
                <a  rel="position: 'inside' , showTitle: false, adjustX:-4, adjustY:-4" class="thumbnail cloud-zoom" href="{!! URL('resources/upload/details/'.$prd_img->images) !!}">
                  <img src="{!! URL('resources/upload/details/'.$prd_img->images) !!}" alt="{!! $product->alias !!}" title="{!! $product->alias !!}">
                </a>
              </li>
            @endforeach
          </ul>
          <ul class="thumbnails mainimage">
            <li class="producthtumb">
              <a class="thumbnail" >
                <img  src="{!! URL('resources/upload/'.$product->image) !!}" alt="{!! $product->alias !!}" title="{!! $product->alias !!}">
              </a>
            </li>
            @foreach($product_images as $prd_img)
            <li class="producthtumb">
              <a class="thumbnail" >
                <img  src="{!! URL('resources/upload/details/'.$prd_img->images) !!}" alt="{!! $product->alias !!}" title="{!! $product->alias !!}">
              </a>
            </li>
            @endforeach
          </ul>
        </div>
         <!-- Right Details-->
        <div class="span7">
          <div class="row">
            <div class="span7">
              <h1 class="productname"><span class="bgnone">{!! $product->name !!}</span></h1>
              <div class="productprice">
                <div class="productpageprice">
                  <span style="font-size: 14px;" class="spiral"></span>{!! number_format($product->price*(1-$product->sale_off/100),'0','.',',') !!} VNĐ</div>
              </div>
              <ul class="productpagecart">
                <li>
                    @if($product->status==1) 
                        <a class="cart" href="#" onclick="buyAcc({!! $product->id !!});">Mua ngay</a>
                    @else
                        <a class="cart" href="#" onclick="javascript:void(0);">Đã bán</a>    
                    @endif
                </li>
              </ul>
         <!-- Product Description tab & comments-->
         <div class="productdesc">
                <ul class="nav nav-tabs" id="myTab">
                  <li class="active"><a href="#description">Description</a>
                  </li>
                  <li><a href="#specification">Specification</a>
                  </li>
                  <li><a href="#review">Review</a>
                  </li>
                  <li><a href="#producttag">Tags</a>
                  </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="description">
                    <h2>{!! $product->name !!}</h2>
                    <br>
                    <br>
                    {!! $product->content !!}
                  </div>
                  <div class="tab-pane " id="specification">
                    <ul class="productinfo">
                      <li>
                        <span class="productinfoleft"> Product Code:</span> Product 16 </li>
                      <li>
                        <span class="productinfoleft"> Reward Points:</span> 60 </li>
                      <li>
                        <span class="productinfoleft"> Availability: </span> In Stock </li>
                      <li>
                        <span class="productinfoleft"> Old Price: </span> $500.00 </li>
                      <li>
                        <span class="productinfoleft"> Ex Tax: </span> $500.00 </li>
                      <li>
                        <span class="productinfoleft"> Ex Tax: </span> $500.00 </li>
                      <li>
                        <span class="productinfoleft"> Product Code:</span> Product 16 </li>
                      <li>
                        <span class="productinfoleft"> Reward Points:</span> 60 </li>
                    </ul>
                  </div>
                  <div class="tab-pane" id="review">
                    <h3>Write a Review</h3>
                    <form class="form-vertical">
                      <fieldset>
                        <div class="control-group">
                          <label class="control-label">Text input</label>
                          <div class="controls">
                            <input type="text" class="span3">
                          </div>
                        </div>
                        <div class="control-group">
                          <label class="control-label">Textarea</label>
                          <div class="controls">
                            <textarea rows="3"  class="span3"></textarea>
                          </div>
                        </div>
                      </fieldset>
                      <input type="submit" class="btn btn-orange" value="continue">
                    </form>
                  </div>
                  <div class="tab-pane" id="producttag">
                    <ul class="tags">
                      <li><a href="#"><i class="icon-tag"></i> Webdesign</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> html</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> html</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> css</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> jquery</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> css</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> jquery</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> Webdesign</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> css</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> jquery</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> Webdesign</a>
                      </li>
                      <li><a href="#"><i class="icon-tag"></i> html</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="related" class="row">
    <div class="container">
      <h1 class="heading1"><span class="maintext">Sản phẩm cùng khoảng giá</span></h1>
        <ul class="thumbnails">
            @foreach($same_product as $same_product_item)
            <li class="span3">
                <a  style="min-height: 50px;" class="prdocutname" href="product.html">{!! $same_product_item->name !!}</a>
                <div class="thumbnail">
                    <span class="sale tooltip-test">Sale</span>
                    <a href="{!! URL('/san-pham',[$same_product_item->id,$same_product_item->alias]) !!}"><img alt="{!! $same_product_item->alias !!}" src="{!! asset('resources/upload/'.$same_product_item->image) !!}"></a>
                    <div class="pricetag">
                        <span class="spiral"></span><a href="{!! URL('/san-pham',[$same_product_item->id,$same_product_item->alias]) !!}" class="productcart">Chi tiết</a>
                        <div class="price">
                            <div style="font-size: 13px; color:#ff0000;" class="pricenew"><span style="color: blue; font-weight: bold; display: block; float:left; text-align: left; width: 35px;">Card</span> {!! number_format($same_product_item->price*(1-$same_product_item->sale_off/100),'0','.',',') !!} VNĐ</div>
                            <div class=""><span style="color: blue; font-weight: bold; display: block; float:left; text-align: left; width: 35px;">ATM</span><span style="color: red; font-weight: bold;">{!! number_format($same_product_item->price_atm*(1-$same_product_item->sale_off/100),'0','.',',') !!} VNĐ</span></div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
  </section>
  <!--  Related Products-->
  <section id="related" class="row">
    <div class="container">
      <h1 class="heading1"><span class="maintext">Sản phẩm đặc biệt</span></h1>
        <ul class="thumbnails">
            @foreach($special_product as $special_product_item)
            <li class="span3">
                <a  style="min-height: 50px;" class="prdocutname" href="product.html">{!! $special_product_item->name !!}</a>
                <div class="thumbnail">
                    <span class="sale tooltip-test">Sale</span>
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
  <!-- Popular Brands-->
</div>
@endsection