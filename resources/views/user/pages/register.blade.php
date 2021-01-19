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
        <li class="active">Đăng kí tài khoản</li>
      </ul>
      <div class="row">        
        <!-- Register Account-->
        <div class="span9">
          <h1 class="heading1"><span class="maintext">Đăng kí tài khoản</span><span class="subtext">Đăng kí thông tin tài khoản của bạn với chúng tôi</span></h1>
            @if(Session::has('errors'))
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            @endif
          <form method="POST" action="{!! route('postDangki') !!}" class="form-horizontal">
            {!! csrf_field() !!}
            <h3 class="heading3">Thông tin cá nhân</h3>
            <div class="registerbox">
              <fieldset>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Họ và tên:</label>
                  <div class="controls">
                    <input type="text" name="txtUser" placeholder="Họ và tên" autocomplete="off" value="{!! old('txtUser') !!}" class="input-xlarge">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Email:</label>
                  <div class="controls">
                    <input type="text" name="txtEmail" placeholder="Mời nhập email" autocomplete="off" value="{!! old('txtEmail') !!}" class="input-xlarge">
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label"><span class="red">*</span> Số điện thoại:</label>
                  <div class="controls">
                    <input type="text" name="txtPhone" placeholder="Mời nhập số điện thoại" autocomplete="off" value="{!! old('txtPhone') !!}" class="input-xlarge">
                  </div>
                </div>
                <div class="control-group" style="display: none;">
                  <label class="control-label"> Fax:</label>
                  <div class="controls">
                    <input type="text"  class="input-xlarge">
                  </div>
                </div>
              </fieldset>
            </div>
            <h3 class="heading3">Mật khẩu của bạn</h3>
            <div class="registerbox">
              <fieldset>
                <div class="control-group">
                  <label  class="control-label"><span class="red">*</span> Mật khẩu:</label>
                  <div class="controls">
                    <input type="password" name="txtPass" placeholder="Mời nhập mật khẩu" autocomplete="off" class="input-xlarge">
                  </div>
                </div>
                <div class="control-group">
                  <label  class="control-label"><span class="red">*</span> Xác nhận mật khẩu:</label>
                  <div class="controls">
                    <input type="password" name="txtRePass" placeholder="Nhập lại mật khẩu" autocomplete="off" class="input-xlarge">
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="pull-right">
              <label class="checkbox inline">
                <input type="checkbox" value="option2" >
              </label>
              Tôi đồng ý với các <a href="#" >điều khoản</a>
              &nbsp;
              <input type="Submit" class="btn btn-orange" value="Đăng kí">
            </div>
          </form>
          <div class="clearfix"></div>
          <br>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection