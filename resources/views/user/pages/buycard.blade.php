@extends('user.master')
@section('content')
<div id="maincontainer">
    <section id="product">
        <div class="container">
         <!--  breadcrumb --> 
          <div class="row">
            <div class="span8 offset2">
                <form onsubmit="return checkSubmit();" action="{!! route('postNapThe') !!}" method="post" id="fnapthe">
                    {!! csrf_field() !!}
                    @if(Session::has('flash-message'))
                    <div class="alert alert-{!! Session::get('flash-level') !!}">
                        {!! Session::get('flash-message') !!}
                    </div>
                    @endif
                    <table class="table table-condensed table-bordered">
                        <tbody>
                            <tr>
                                <td>Loại thẻ</td>
                                <td>
                                    <select name="card_type_id" id="card_type_id" style="width: 200px;">
                                        <option @if(old('card_type_id')==1) selected @endif value="1">Viettel</option>
                                        <option @if(old('card_type_id')==2) selected @endif value="2">Mobiphone</option>
                                        <option @if(old('card_type_id')==3) selected @endif value="3">Vinaphone</option>
                                        <option @if(old('card_type_id')==4) selected @endif value="4">Gate</option>
                                    </select>
                                </td>
                            </tr>
    						
                            <tr>
                                <td>Mệnh giá</td>
                                <td>
                                    <select name="price_guest" id="price_guest" style="width: 200px;">   								
    									<option @if(old('price_guest')==0) selected @endif  value="0">- Chọn mệnh giá -</option>
                                        <option @if(old('price_guest')==10000) selected @endif value="10000">10.000</option>
                                        <option @if(old('price_guest')==20000) selected @endif value="20000">20.000</option>
                                        <option @if(old('price_guest')==30000) selected @endif value="30000">30.000</option>
                                        <option @if(old('price_guest')==50000) selected @endif value="50000">50.000</option>
                                        <option @if(old('price_guest')==100000) selected @endif value="100000">100.000</option>
                                        <option @if(old('price_guest')==200000) selected @endif value="200000">200.000</option>
                                        <option @if(old('price_guest')==300000) selected @endif value="300000">300.000</option>
                                        <option @if(old('price_guest')==500000) selected @endif value="500000">500.000</option>
                                        <option @if(old('price_guest')==1000000) selected @endif value="1000000">1.000.000</option>
                                    </select>
    							</td>
                            </tr>
    						
                            <tr>
                                <td>Mã thẻ</td>
                                <td><input type="text" value="{!! old('pin') !!}" name="pin" required=""  autocomplete="off" style="width: 200px;"/></td>
                            </tr>
                            <tr>
                                <td>Seri</td>
                                <td><input type="text" value="{!! old('seri') !!}" name="seri" required="" autocomplete="off" style="width: 200px;"/></td>
                            </tr>
    					  						   						
                            <tr>
                                <td>Mã bảo mật</td>
                                <td>
                                    <div id='captcha'>
                                        <img src="{{ captcha_src() }}" id="captcha_image"/>
                                        <a href='javascript:void(0);' id="reload_captcha">reload_captcha</a>
                                    </div>
                                    <script>
                                        $('#reload_captcha').click(function(event){
                                          $('#captcha_image').attr('src', $('#captcha_image').attr('src')+'{{ captcha_src() }}');
                                        });
                                    </script>
                                    <p style="margin-top: 10px;"><input type="text" name="captcha"/></p>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input class="btn btn-info" type="submit" value="Nạp thẻ"/>
                                    <div id="loading_napthe" style="display: none; float: right"><img src="images/loading.gif"/> &nbsp;Xin mời chờ...</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
          </div>
        </div>
    </section>
</div>
<script>
    function checkSubmit()
    {
        if(jQuery("#price_guest").val()==0)
        {
            alert('Bạn phải chọn loại thẻ muốn nạp!');
            return false;
        }
    }
</script>
@endsection