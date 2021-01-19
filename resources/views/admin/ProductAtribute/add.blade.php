@extends('admin.master')
@section('content')
<!-- Page Content -->
<form enctype="multipart/form-data" action="{!! route('admin.ProductAtribute.postAdd') !!}" method="POST">
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Product
                    <small>Add</small>
                </h1>
            </div>
            <div class="col-lg-12">
                @if(Session::has('flash-message'))
                <div class="alert alert-{!! Session::get('flash-level') !!}">
                    {!! Session::get('flash-message') !!}
                </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                    <div class="form-group">
                        <label>Product Atribute Category Parent</label>
                        <select name="atrCateParent" class="form-control">
                            <option value="">Please Choose Product Atribute Category</option>
                            @foreach($prd_atr_parent as $key=>$value)
                                 <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                        <h3 class="label label-danger">{{ $errors->first('cateParent') }}</h3><br/>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="txtName" placeholder="Please Enter Product's Name" value="{!! old('txtName') !!}" /><br/>
                         <h3 class="label label-danger">{{ $errors->first('txtName') }}</h3>                  
                    </div>
                    <div class="form-group">
                        <label>Product Atribute Status</label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="1" checked="" type="radio" <?php if(Input::old('rdoStatus')== "1") { echo 'checked="checked"'; } ?>>Visible
                        </label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="0" type="radio" <?php if(Input::old('rdoStatus')== "2") { echo 'checked="checked"'; } ?>>Invisible
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Product Atribute Add</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                
                     
                
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<form> 
<!-- /#page-wrapper -->
@endsection