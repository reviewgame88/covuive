@extends('user.master')
@section('content')
<div id="maincontainer">
  <section id="product">
    <div class="container">
      <!--  breadcrumb --> 
      <ul class="breadcrumb">
        <li>
          <a href="#">Trang chủ</a>
          <span class="divider">/</span>
        </li>
        <li class="active">Đăng nhập</li>
      </ul>
       <!-- Account Login-->
      <div class="row">  
        <div class="span9">
          @if(Session::has('errors'))
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
          @endif  
          <h1 class="heading1"><span class="maintext">Đăng nhập</span><span class="subtext">Đăng nhập lần đầu tại đây và xem thông tin tài khoản của bạn</span></h1>
          <section class="newcustomer">
            <h2 class="heading2">Bạn chưa có tài khoản? </h2>
            <div class="loginbox">
              <h4 class="heading4">Đăng kí tài khoản</h4>
              <p>Bằng cách tạo một tài khoản, bạn sẽ có thể mua sắm nhanh hơn, được cập nhật về trạng thái của đơn đặt hàng và theo dõi các đơn đặt hàng bạn đã thực hiện trước đó.</p>
              <br>
              <a href="{!! route('getDangki') !!}" class="btn btn-orange">Đăng kí</a>
            </div>
          </section>
          <section class="returncustomer">
            <h2 class="heading2">Đăng nhập </h2>
            <div class="loginbox">
              <form class="form-vertical" method="POST" action="{!! route('postDangnhap') !!}">
                {!! csrf_field() !!}
                <fieldset>
                  <div class="control-group">
                    <label  class="control-label">E-Mail:</label>
                    <div class="controls">
                      <input type="text" name="email" class="span3">
                    </div>
                  </div>
                  <div class="control-group">
                    <label  class="control-label">Mật khẩu:</label>
                    <div class="controls">
                      <input type="password" name="password" class="span3">
                    </div>
                  </div>
                  <a class="" href="#">Quên mật khẩu?</a>
                  <br>
                  <br>
                  <button type="submit" id="btn btn-smlogin-button" class="btn btn-orange">Đăng nhập</button>
                  <button type="button" class="facebook_button" onclick="window.location='redirect/facebook';" style="height: 34px; margin-left:20px;" type="submit">Đăng nhập bằng Facebook</button>
                  <input type="hidden" name="game_type" value="{{ $game_type }}">
                </fieldset>
              </form>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection