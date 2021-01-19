<style>
    .dropdown-user
    {
        position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:160px;padding:5px 0;margin:2px 0 0;font-size:14px;text-align:left;list-style:none;background-color:#fff;-webkit-background-clip:padding-box;background-clip:padding-box;border:1px solid #ccc;border:1px solid rgba(0,0,0,.15);border-radius:4px;-webkit-box-shadow:0 6px 12px rgba(0,0,0,.175);box-shadow:0 6px 12px rgba(0,0,0,.175);
    }
    .dropdown-menu:before, .dropdown-menu:after
    {
        content: none;
    }
</style>
<div class="headerstrip">
    <div class="container">
        <div class="row">
            <div class="span12">
                <a href="{!! URL('/') !!}" class="logo pull-left"><img src="{!! URL('public/user/img/logo.png')!!}" alt="SimpleOne" title="SimpleOne"></a>
                <!-- Top Nav Start -->
                <div class="pull-left">
                    <div class="navbar" id="topnav">
                        <div class="navbar-inner">
                            <ul class="nav" >
                                <li><a class="home active" href="{!! URL('/') !!}">Trang chủ</a>
                                </li>
                                <li>
                                    @if (Auth::guest())
                                    <a class="myaccount" href="{!! route('getDangnhap') !!}">Đăng nhập</a>
                                    @endif
                                </li>
                                <li><a class="buycard" href="{!! route('getLichSu') !!}">Nạp thẻ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Top Nav End -->
                <div class="pull-right">
                    <div class="navbar" id="topnav">
                        @if (!Auth::guest())
                        <div class="navbar-inner" style="float: left; padding-right: 0px;">
                            <ul class="nav" style="" >
                                <li>
                                    <div><a class="myaccount" href="">Xin chào! {{ Auth::user()->name }} </a></div>
                                    <div class="" style="color: white; text-align: right; margin-right: 22px;">Số dư : {!! number_format(Auth::user()->current_money,'0','.',',') !!} VNĐ</div>
                                </li>
                            </ul>
                        </div>
                        <li class="dropdown" style="float: left;" onmouseover="$(this).unbind('hover');">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                                <i style="color: white !important; margin-top: 28px;" class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user" style="left:-155px; top:125%; color: black !important; padding: 0px;">
                                <li>
                                    <a href="{!! route('getLichSu') !!}" style="color: black !important; font-size: 12px;"><i class="fa fa-gear fa-fw"></i>Lịch sử GD</a>
                                </li>
                                <li><hr style="margin: 0px;" /></li>
                                <li>
                                    <a href="{!! route('logout') !!}"  style="color: black !important;  font-size: 12px;"><i class="fa fa-sign-out fa-fw"></i>Thoát</a>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>