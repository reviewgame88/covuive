@extends('admin.master')
@section('content')
<!-- Page Content -->
<form action="{!! route('admin.ProductAtribute.postEdit',$product_atr['id']) !!}" method="POST" enctype="multipart/form-data" id="frmEditProduct">
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Product
                    <small>Edit</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                
                <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="txtName" placeholder="Please Enter Username" value="{!! old('txtName',isset($product_atr) ? $product_atr['name'] : null) !!}" />
                        <h3 class="label label-danger">{!! $errors->first('txtName') !!}</h3>
                    </div>
                    <div class="form-group">
                        <label>Product Atribute Category Parent</label>
                        <select name="atrCateParent" class="form-control">
                            <option value="">Please Choose Product Atribute Category</option>
                            @foreach($prd_atr_parent as $key=>$value)
                                 <option value="{{ $value['id'] }}" <?php if($product_atr['product_atr_cate_id']==$value['id']) echo "selected=''"; ?> >{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                        <h3 class="label label-danger">{{ $errors->first('cateParent') }}</h3><br/>
                    </div>
                    <div class="form-group">
                        <label>Product Status</label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="1" type="radio" <?php if($product_atr['status']==1) echo "checked='checked'"; ?>>Visible
                        </label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="0" type="radio" <?php if($product_atr['status']==0) echo "checked='checked'"; ?>>Invisible
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Product Edit</button>
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