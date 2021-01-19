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
                        <th>Username</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $data)
                    <tr class="odd gradeX" align="center">
                        <td>{!! $data['id'] !!}</td>
                        <td>{!! $data['name'] !!}</td>
                        <td>{!! $data['email'] !!}</td>
                        <td>
                            @if($data['level']==1)
                                Admin
                            @else
                                Member
                            @endif
                        </td>
                        <td>
                            @if($data['status']==1)
                                Hiện
                            @else
                                Ẩn
                            @endif
                        </td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="{!! route('admin.user.getDelete',$data['id']) !!}" onclick="return xacnhanxoa();"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="{!! route('admin.user.getEdit',$data['id']) !!}">Edit</a></td>
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