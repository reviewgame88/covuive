@extends('admin.master')
@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Trạng thái thẻ
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
                <form action="{!! route('admin.CheckCard.postEdit',$buy_card['id']) !!}" method="POST">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="2"
                                 @if($buy_card['status']==2)
                                     checked="checked"
                                 @endif
                                   type="radio">Chờ xử lý
                        </label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="1"
                                 @if($buy_card['status']==1)
                                     checked="checked"
                                 @endif
                                   type="radio">Thành công
                        </label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="0"
                                    @if($buy_card['status']==0)
                                        checked="checked"
                                    @endif
                                   type="radio">Thất bại
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
                    <button type="reset" class="btn btn-default" style="margin-left: 20px;">Reset</button>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection