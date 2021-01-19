@extends('admin.master')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>List</small>
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
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Tài khoản</th>
                        <th>Seri</th>
                        <th>Mã thẻ</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày nạp</th>
                        <th>Xóa</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buy_card as $buy_card)
                    <tr class="odd gradeX" align="center">
                        <td>{!! $buy_card->id !!}</td>
                        <td>{!! $buy_card->name !!}</td>
                        <td>{!! $buy_card->seri !!}</td>
                        <td>{!! $buy_card->pass_card !!}</td>
                        <td>{!! $buy_card->amount !!}</td>
                        <td>
                            @if($buy_card->status==1)
                                <span style="color: blue;">Thành công</span>
                            @elseif($buy_card->status==2)
                                <span style="color: green;">Chờ xử lý</span>
                            @elseif($buy_card->status==0)   
                                <span style="color: red;">Thất bại</span>
                            @endif
                        </td>
                        <td>
                            {!! $buy_card->created_at !!}
                        </td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="{!! route('admin.CheckCard.getDelete',$buy_card->id) !!}" onclick="return xacnhanxoa();"> Xóa</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! route('admin.CheckCard.getEdit',$buy_card->id) !!}">Sửa</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection