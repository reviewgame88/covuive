@extends('user.master')
@section('content')
<div id="maincontainer">
    <section id="product">
        <div class="container">
         <!--  breadcrumb --> 
          <div class="row">
            <div class="span2 offset1">
                <div class="sidebar-nav">
                  <div class="navbar navbar-default" role="navigation">
                    <div class="navbar-collapse sidebar-navbar-collapse in collapse" style="height: auto;">
                      <ul class="nav navbar-nav">
                        <li class="active"><a href="#htab1" data-toggle="tab">Nạp thẻ</a></li>
                        <li><a href="#htab2" onclick="checkNapThe();" data-toggle="tab">Lịch sử nạp thẻ</a></li>
                        <li><a href="#htab3" data-toggle="tab">Lịch sử mua</a></li>
                      </ul>
                    </div><!--/.nav-collapse -->
                  </div>
                </div>
            </div>
            <div class="span8" style="border-left: red 2px solid;">
                <div class="tab-content" style="min-height: 500px;">
                    <div role="tabpanel" class="tab-pane fade in active" id="htab1">
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
                                                <a href='javascript:void(0);' id="reload_captcha"><i class="icon-refresh" style="width: 15px;"></i></a>
                                            </div>
                                            <script>
                                                $('#reload_captcha').click(function(event){
                                                  $('#captcha_image').attr('src', $('#captcha_image').attr('src')+'{{ captcha_src() }}');
                                                });
                                            </script>
                                            <p style="margin-top: 10px;"><input type="text" autocomplete="off" name="captcha"/></p>
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
                    <div role="tabpanel" class="tab-pane fade" id="htab2">
                        <h3>Lịch sử nạp thẻ</h3>
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Seri</th>
                                    <th>Mã thẻ</th>
                                    <th>Trạng Thái</th>
                                    <th>Thời gian nạp</th>
                                </tr>
                            </thead>
                            <tbody id="content">
                                
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="htab3">
                        <h3>Lịch sử mua</h3>
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã tài khoản</th>
                                    <th>Thông tin tài khoản</th>
                                    <th>Thời gian nhận</th>
                                </tr>
                            </thead>
                            <tbody id="content_acc">
                                <?php $i=1; ?>
                                @foreach($account_info as $same_product_item)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><a target="_blank" href="{!! URL('/san-pham',[$same_product_item->id,$same_product_item->alias]) !!}">{{ $same_product_item->id }}</a></td>
                                        <td>{{ $same_product_item->content }}</td>
                                        <td>{{ $same_product_item->time_buy }}</td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </section>
</div>
<script>
    function checkNapThe()
    {
        var url = 'http://localhost/project/check-nap-the';
            $.ajax({
                url : url,
                type : 'GET',
                cache : false,
                data : {},
                success : function (data, textStatus) {
                    if(textStatus=='success'){
                        var str = "";
                        var i = 1;
                        for(var items in data)
                        {
                            var status = "";
                            if(data[items]['status']==1)
                            {
                                status = "<span style='color:blue;'>Thành công</span>";
                            }
                            else if(data[items]['status']==2)
                            {
                                status = "<span style='color:green;'>Đang xử lý</span>";
                            }
                            else if(data[items]['status']==0)
                            {
                                status = "<span style='color:red;'>Thất bại</span>";
                            }
                            
                            str+="<tr>"
                               +     "<td>"+i+"</td>"
                               +     "<td>"+data[items]['seri']+"</td>"
                               +     "<td>"+data[items]['pass_card']+"</td>"
                               +     "<td>"+status+"</td>"
                               +     "<td>"+data[items]['created_at']+"</td>"
                               + "</tr>";
                               i++;
                        }
                        $("#content").html(str);
                    }
                    else  bootbox.alert('Đã có lỗi xảy ra! Xin vui lòng thử lại');
                }
            });
    }    
</script>
@endsection