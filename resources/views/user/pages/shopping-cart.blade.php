@extends('user.master')
@section('content')
<div id="maincontainer">
  <section id="product">
    <div class="container">
     <!--  breadcrumb --> 
      <ul class="breadcrumb">
        <li>
          <a href="#">Home</a>
          <span class="divider">/</span>
        </li>
        <li class="active"> Shopping Cart</li>
      </ul>       
      <h1 class="heading1"><span class="maintext"> Giỏ hàng </span><span class="subtext"> Tất cả sản phẩm trong giỏ</span></h1>
      <!-- Cart-->
      <div class="cart-info">
        <table class="table table-striped table-bordered">
          <tr>
            <th class="image">Hình ảnh</th>
            <th class="name">Tên SP</th>
            <th class="model">Loại SP</th>
            <th class="quantity">Số lượng</th>
             <th>Khuyến mãi</th>
              <th class="total">Hành động</th>
            <th class="price">Giá</th>
            <th class="total">Tổng</th>
           
          </tr>
          <?php
                $i = 0;
                $stt = "abc".$i;
          ?>
          @foreach($content as $item)
            <?php
                  $cate = DB::table('cates')->select('name')->where('id',$item->options->cate_id)->first();
            ?>
          <tr id="{!! $item->rowid !!}">
            <td class="image"><a href="#"><img title="{!! $item->name !!}" alt="{!! $item->name !!}" src="{!! URL('resources/upload/'.$item->options->img) !!}" height="50" width="50"></a></td>
            <td  class="name"><a href="#">{!! $item->name !!}</a></td>
            <td class="model">{!! $cate->name !!}</td>
            <td class="quantity"><input type="number" max="20" min="1" value="{!! $item->qty !!}" id="{!! $stt !!}" name="quantity[40]" class="span1"></td>
              <td>{!! $item->options->sale_off !!}%</td>
             <td class="action"> <a href="#"><img onclick="if(xacnhanxoa('Bạn muốn cập nhật sản phẩm này?')) updateProduct('{!! $item->rowid !!}','{!! $stt !!}',{!! $item->price !!});" class="tooltip-test update" data-original-title="Cập nhật" src="{!! URL('public/user/img/update.png')!!}" alt=""></a>
              <a href="javascript:void(0)"><img onclick="if(xacnhanxoa('Bạn có muốn xóa mục này không?')) delProduct('{!! $item->rowid !!}');" class="tooltip-test remove" data-original-title="Xóa"  src="{!! URL('public/user/img/remove.png')!!}" alt=""></a></td>
            <td class="price">{!! number_format($item->price,'0','.',',')!!} VNĐ</td>
            <td class="total">{!! number_format($item->price*$item->qty,'0','.',',')!!} VNĐ</td>
              <?php
                  $i++;
                  $stt = "abc".$i;
              ?>
           @endforeach
          </tr>
        </table>
      </div>
      <div class="container">
      <div class="pull-right">
          <div class="span4 pull-right">
            <table class="table table-striped table-bordered ">
                <td><span class="extra bold totalamout">Tổng :</span></td>
                <td><span class="bold totalamout" id="total">{!!number_format($total,'0','.',',')!!} VNĐ</span></td>
              </tr>
            </table>
            <input type="submit" value="Thanh toán" class="btn btn-orange pull-right">
            <input onclick="window.history.back();" type="button" value="Tiếp tục mua sắm" class="btn btn-orange pull-right mr10">
          </div>
        </div>
        </div>
    </div>
  </section>
</div>
@endsection