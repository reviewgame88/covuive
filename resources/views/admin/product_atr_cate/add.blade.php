@extends('admin.master')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Category
                    <small>Thêm</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                <form action="{!! route('admin.product_atr_cate.getAdd') !!}" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
                    <div class="form-group">
                        <label>Thuộc loại danh mục</label>
                        <select name="cateParent" class="form-control">
                            <option value="0">Please Choose Category</option>
                            <?php cateParent($parent); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product Atribute Category Name</label>
                        <input class="form-control" name="txtCateName" placeholder="Please Enter Category Name" />
                        <p style="color:red;">{{ $errors->first('txtCateName') }}</p>
                    </div>
                    <div class="form-group">
                        <label>Product Atribute Category Status</label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="1" checked="" type="radio">Visible
                        </label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="0" type="radio">Invisible
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Category Add</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection