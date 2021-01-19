@extends('admin.master')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Edit</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @if(Session::has('errors'))
                    <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>
                                {!! $error !!}
                            </li>
                        @endforeach
                    </ul>
                @endif
                <form action="{!! route('admin.user.postEdit',$id) !!}" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="txtUser" value="{!! $user['name'] !!}" disabled />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="txtPass" value="" placeholder="Please Enter Password" />
                    </div>
                    <div class="form-group">
                        <label>RePassword</label>
                        <input type="password" class="form-control" name="txtRePass" placeholder="Please Enter RePassword" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="txtEmail" value="{!! $user['email'] !!}" placeholder="Please Enter Email" />
                    </div>
                    <div class="form-group">
                        <label>User Level</label>
                        <label class="radio-inline">
                            <input name="rdoLevel" value="1"
                                 @if($user['level']==1)
                                     checked="checked"
                                 @endif
                                   type="radio">Admin
                        </label>
                        <label class="radio-inline">
                            <input name="rdoLevel" value="2"
                                    @if($user['level']==2)
                                        checked="checked"
                                    @endif
                                   type="radio">Member
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">User Edit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection