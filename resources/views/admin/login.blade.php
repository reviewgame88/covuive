<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    
    
    
    
        <link rel="stylesheet" href="{!! URL('public/admin/login/css/style.css')!!}">

    
    
    
  </head>

  <body>
    @if(Session::has('errors'))
        <script>
            bootbox.alert("adad");
        </script>
    @endif
    <div class="wrapper">
	<div class="container">
		<h1>Welcome</h1>
        @if(Session::has('errors'))
            @foreach($errors->all() as $error)
                {!! $error !!}
            @endforeach
        @endif
		<form class="form" method="POST" role="form" action="">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
			<input type="text" placeholder="Email" name="email">
			<input type="password" placeholder="Password" name="password">
			<button type="submit" id="login-button">Login</button>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
    <script src="{!! URL('public/admin/bower_components/jquery/dist/jquery.min.js')!!}"></script>

        <script src="{!! URL('public/admin/login/js/index.js')!!}"></script>
        <script src="{!! URL('public/bootbox.min.js') !!}"></script>
  </body>
</html>
