<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Shop thời đại mới</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="@yield('description')">
  <meta name="author" content="Minh Thanh">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300italic,400italic,600,600italic' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Crete+Round' rel='stylesheet' type='text/css'>
  <link href="{!! URL('public/user/css/bootstrap.css')!!}" rel="stylesheet">
  <link href="{!! URL('public/user/css/bootstrap-responsive.css')!!}" rel="stylesheet">
  <link href="{!! URL('public/user/css/style.css')!!}" rel="stylesheet">
  <link href="{!! URL('public/user/css/flexslider.css')!!}" type="text/css" media="screen" rel="stylesheet"  />
  <link href="{!! URL('public/user/css/jquery.fancybox.css')!!}" rel="stylesheet">
  <link href="{!! URL('public/user/css/cloud-zoom.css')!!}" rel="stylesheet">
  <link href="{!! URL('public/admin/dist/css/sb-admin-2.css') !!}" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <script src="{!! URL('public/user/js/jquery.js')!!}"></script>
  <script src="{!! URL('public/user/js/bootstrap.js')!!}"></script>
  <script type="text/javascript"  src="{!! URL('public/bootbox.min.js')!!}"></script>

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->


  <!-- fav -->
  <link rel="shortcut icon" href="{!! URL('public/user/assets/ico/favicon.html')!!}">
</head>
<body>
  <!-- Header Start -->

  <header>
    @include('user.blocks.header')
    <div class="container">
      @include('user.blocks.nav')
    
    </div>
  </header>
  <!-- Header End -->

  <div id="maincontainer">
    <div id="second-main">
        <!-- Slider Start-->
        <!--@yield('slider')-->
    
        <!-- Slider End-->
        
        <!-- Slider Start-->
        @yield('search')
    
        <!-- Slider End-->
        
        <!-- Featured Product-->
        @yield('content')

    </div>
        <!-- Footer -->
        @include('user.blocks.footer')
    
    <!-- javascript
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="{!! URL('public/user/js/myScript.js')!!}"></script>
    <script src="{!! URL('public/user/js/respond.min.js')!!}"></script>
    <script src="{!! URL('public/user/js/application.js')!!}"></script>
    <script src="{!! URL('public/user/js/bootstrap-tooltip.js')!!}"></script>
    <script defer src="{!! URL('public/user/js/jquery.fancybox.js')!!}"></script>
    <script defer src="{!! URL('public/user/js/jquery.flexslider.js')!!}"></script>
    <script type="text/javascript" src="{!! URL('public/user/js/jquery.tweet.js')!!}"></script>
    <script  src="{!! URL('public/user/js/cloud-zoom.1.0.2.js')!!}"></script>
    <script  type="text/javascript" src="{!! URL('public/user/js/jquery.validate.js')!!}"></script>
    <script type="text/javascript"  src="{!! URL('public/user/js/jquery.carouFredSel-6.1.0-packed.js')!!}"></script>
    <script type="text/javascript"  src="{!! URL('public/user/js/jquery.mousewheel.min.js')!!}"></script>
    <script type="text/javascript"  src="{!! URL('public/user/js/jquery.touchSwipe.min.js')!!}"></script>
    <script type="text/javascript"  src="{!! URL('public/user/js/jquery.ba-throttle-debounce.min.js')!!}"></script>
    <script defer src="{!! URL('public/user/js/custom.js')!!}"></script>
      <!-- Bootbox -->


    @if(Session::has('message'))
      <script>
        bootbox.alert("<p style='color:#942a25; font-weight: bold;'>Cảm ơn quý khách đã tham gia góp ý. Chúng tôi sẽ phản hồi lại trong thời gian sớm nhất.</p>");
      </script>
    @endif
  
<script>
function openNav() {
    $("#mySidenav").css("padding-left","10px");
    document.getElementById("mySidenav").style.width = "280px";
    document.getElementById("second-main").style.marginLeft = "300px";
}

function closeNav() {
    $("#mySidenav").css("padding-left","0");
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("second-main").style.marginLeft= "0";
}
</script>

</body>
</html>