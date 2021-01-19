@extends('admin.master')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Category
                    <small>Edit</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-group">
                        <label>Category Parent</label>
                        <select class="form-control" name="cateParent">
                            <option value="">Please Choose Category</option>
                            <?php

                                cateParent($parent,0,"--", $dataEdit['parent_id']);  
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category Name</label>
                        <input class="form-control" name="txtCateName" placeholder="Please Enter Category Name" value="{!! old('txtCateName', isset($dataEdit) ? $dataEdit['name'] : null) !!}" />
                    </div>
                    <div class="form-group">
                        <label>Category Order</label>
                        <input class="form-control" name="txtOrder" placeholder="Please Enter Category Order" value="{!! old('txtOrder', isset($dataEdit) ? $dataEdit['order'] : null) !!}" />
                    </div>
                    <div class="form-group">
                        <label>Category Keywords</label>
                        <input class="form-control" name="txtKeyword" placeholder="Please Enter Category Keywords" value="{!! old('txtKeyword', isset($dataEdit) ? $dataEdit['keywords'] : null) !!}"/>
                    </div>
                    <div class="form-group">
                        <label>Category Description</label>
                        <textarea class="form-control" rows="3" name="txtDescript" value="">{!! old('txtKeyword', isset($dataEdit) ? $dataEdit['description'] : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Category Status</label>
                        @if($dataEdit['status'] == 1)
                            <label class="radio-inline">
                                <input name="rdoStatus" value="1" checked="checked" type="radio">Visible
                            </label>
                            <label class="radio-inline">
                                <input name="rdoStatus" value="0" type="radio">Invisible
                            </label> 
                        @else
                            <label class="radio-inline">
                                <input name="rdoStatus" value="1" type="radio">Visible
                            </label>
                            <label class="radio-inline">
                                <input name="rdoStatus" value="0" checked="checked" type="radio">Invisible
                            </label>  
                        @endif
                        
                    </div>
                    <button type="submit" class="btn btn-default">Category Edit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection