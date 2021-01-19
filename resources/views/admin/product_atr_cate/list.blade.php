@extends('admin.master')
@section('content')
<div id="page-wrapper">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <small>Danh sách nhóm thuộc tính</small>
            </h1>
            <button class="btn btn-small btn-info" style="margin-bottom: 30px;" onclick="location='{!! URL::route('admin.product_atr_cate.getAdd') !!}'">Thêm nhóm thuộc tính</button>
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
                    <th></th>
                    <th>Tên</th>
                    <th>Game</th>
                    <th>Trạng thái</th>
                    <th>Xóa</th>
                    <th>Sửa</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 0; ?>
                @foreach($productInfo as $prdInfo)
                <?php $stt += 1; ?>
                <tr class="odd gradeX" align="center">
                    <td>{{ $stt }}</td>
                    <td>{{ $prdInfo["name"] }}</td>
                    <td>
                        @if($prdInfo['cate_id']==0)
                            None
                        @else
                            <?php
                                $data = DB::table('cates')->where('id',$prdInfo["cate_id"])->first();
                                echo $data->name;
                            ?>
                        @endif
                        
                    </td>
                    <td>
                    @if($prdInfo["status"] == 0)
                         Ẩn 
                    @else
                         Hiện 
                    @endif
                    </td>
                    <td class="center"><i class="fa fa-trash-o  fa-fw"></i><span onclick="if(confirm('Do you want delete this product?')) location='{!! URL::route('admin.product_atr_cate.getDelete',$prdInfo['id']) !!}';" style="color:brown; cursor:pointer;"> Delete</span></td>
                    <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! URL::route('admin.product_atr_cate.getEdit',$prdInfo['id']) !!}">Edit</a></td>
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
