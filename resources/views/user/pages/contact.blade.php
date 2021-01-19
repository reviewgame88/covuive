@extends('user.master')
@section('content')
<div id="maincontainer">
  <section id="product">
    <div class="container">
     <!--  breadcrumb --> 
      <ul class="breadcrumb">
        <li>
          <a href="{!! URL('/') !!}">Home</a>
          <span class="divider">/</span>
        </li>
        <li class="active">Liên hệ</li>
      </ul>  
      <!-- Contact Us-->
      <h1 class="heading1"><span class="maintext">Liên hệ</span><span class="subtext"> Liên hệ với chúng tôi</span></h1>
      <div class="row">
        <div class="span9">
          <form action="{!! route('postLienhe') !!}" class="form-horizontal"  method="post">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
            <fieldset>
              <div class="control-group">
                <label for="name" class="control-label">Tên <span class="required">*</span></label>
                <div class="controls">
                  <input type="text"  class="required" id="name" value="" name="name">
                </div>
              </div>
              <div class="control-group">
                <label for="email" class="control-label">Email <span class="required">*</span></label>
                <div class="controls">
                  <input type="email"  class="required" id="email" value="" name="email">
                </div>
              </div>
              <div class="control-group">
                <label for="message" class="control-label">Lời nhắn</label>
                <div class="controls">
                  <textarea  class="required" rows="6" cols="40" id="message" name="message"></textarea>
                </div>
              </div>
              <div class="form-actions">
                <input class="btn btn-orange" type="submit" value="Submit" id="submit_id">
                <input class="btn" type="reset" value="Reset">
              </div>
            </fieldset>
          </form>
        </div>
        
        <!-- Sidebar Start-->
        <div class="span3">
          <aside>
            <div class="sidewidt">
              <h2 class="heading2"><span>Thông tin liên hệ</span></h2>

                Điện thoại : 01648450688<br>
                Email: phieubat19052@gmail.com<br>
              </p>
            </div>
          </aside>
        </div>
        <!-- Sidebar End-->
        
      </div>
    </div>
  </section>
</div>
@endsection