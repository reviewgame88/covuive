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
                <button class="btn btn-small btn-info" style="margin-bottom: 30px;" onclick="location='{!! URL::route('admin.product.getAdd') !!}'">Add Product</button>
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
                        <th>Price</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product as $prd)
                    <tr class="odd gradeX" align="center">
                        <td>{!! $prd['id'] !!}</td>
                        <td>{!! $prd['name'] !!}</td>
                        <td>{!! number_format($prd['price'],0,'.',',') !!} VNĐ</td>
                        <td>
                            <?php
                                echo \Carbon\Carbon::createFromTimeStamp(strtotime($prd['created_at']))->diffForHumans();
                            ?>
                        </td>
                        <td>
                            @if($prd['status']==1)
                                Hiện
                            @else
                                Ẩn    
                            @endif
                        </td>
                        <td>
                            <?php $cate = DB::table('cates')->where('id',$prd["cate_id"])->first(); ?>
                            {!! $cate->name !!}
                        </td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a onclick="return xacnhanxoa();" href="{!! route('admin.product.getDelete',$prd['id']) !!}"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! route('admin.product.getEdit',$prd['id']) !!}">Edit</a></td>
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
