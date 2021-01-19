@extends('admin.master')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Product
                    <small>List</small>
                </h1>
                <button class="btn btn-small btn-info" style="margin-bottom: 30px;" onclick="location='{!! URL::route('admin.ProductAtribute.getAdd') !!}'">Add Product</button>
            </div>
            <div class="col-lg-12">
                @if(Session::has('flash-message'))
                <div class="alert alert-{!! Session::get('flash-level') !!}">
                    {!! Session::get('flash-message') !!}
                </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Product Atr Category</th>
                        <th>Status</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product_atr as $k => $prd)
                    <tr class="odd gradeX" align="center">
                        <td>{!! $prd['id'] !!}</td>
                        <td>{!! $prd['atr_name'] !!}</td>
                        <td>
                            {!! $prd['cate_name'] !!}
                        </td>
                        <td>
                            {!! $prd['name'] !!}
                        </td>
                        <td>
                            @if($prd['status']==1)
                                Hiện
                            @else
                                Ẩn    
                            @endif
                        </td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return xacnhanxoa();" href="{!! route('admin.ProductAtribute.getDelete',$prd['id']) !!}"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! route('admin.ProductAtribute.getEdit',$prd['id']) !!}">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
