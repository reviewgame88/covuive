@extends('admin.master')
@section('content')
<!-- Page Content -->
<form action="{!! route('admin.product.postEdit',$product['id']) !!}" method="POST" enctype="multipart/form-data" id="frmEditProduct">
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
                        <input class="form-control" name="txtName" placeholder="Please Enter Username" value="{!! old('txtName',isset($product) ? $product['name'] : null) !!}" />
                        <h3 class="label label-danger">{!! $errors->first('txtName') !!}</h3>
                    </div>
                    <div class="form-group">
                        <label>Category Parent</label>
                        <select name="cateParent" class="form-control">
                            <option value="">Please Choose Category</option>
                            <?php 
                            cateParent($data,0,"--", $product['cate_id']);   
                            ?>
                        </select>                   
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input class="form-control" name="txtPrice" placeholder="Please Enter Product's Price" value="{!! old('txtPrice',isset($product) ? $product['price'] : null) !!}"/>
                    </div>
                    <div class="form-group">
                        <label>Price Atm</label>
                        <input class="form-control" name="txtPrice" placeholder="Please Enter Product's Price" value="{!! old('txtPriceAtm',isset($product) ? $product['price_atm'] : null) !!}"/>
                    </div>
                    <div class="form-group">
                        <label>Sale Off</label>
                        <input class="form-control" name="txtSaleOff" placeholder="Please Enter Product's Sale Off value" value="{!! old('txtSaleOff',isset($product) ? $product['sale_off'] : null) !!}"/>
                    </div>
                    <div class="form-group">
                        <label>Intro</label>
                        <textarea class="form-control" rows="3" name="txtIntro">{!! old('txtIntro',isset($product) ? $product['intro'] : null) !!}</textarea>
                        <script type="text/javascript">
                            ckeditor('txtIntro');
                        </script>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-control" rows="3" name="txtContent">{!! old('txtContent',isset($product) ? $product['content'] : null) !!}</textarea>
                        <script type="text/javascript">
                            ckeditor('txtContent');
                        </script>
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <img src="{!! URL('resources/upload/'.$product['image']) !!}" class="image_current">
                    </div>
                    <div class="form-group">
                        <label>Ảnh thay thế</label>
                        <input type="file" name="fImage"/>
                        <h3 class="label label-danger">{!! $errors->first('fImage') !!}</h3>
                    </div>
                    <div class="form-group">
                        <label>Product Keywords</label>
                        <input class="form-control" name="txtKeyword" placeholder="Please Enter Category Keywords" value="{!! old('txtKeyword',isset($product) ? $product['keywords'] : null) !!}"/>
                    </div>
                    <div class="form-group">
                        <label>Product Description</label>
                        <textarea class="form-control" rows="3" name="txtDescription">{!! old('txtDescription',isset($product) ? $product['description'] : null) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Gold</label>
                        <input class="form-control" name="txtGold" value="{!! old('txtGold',isset($product) ? $product['gold'] : null) !!}"/>
                    </div>
                    <div class="form-group">
                        <label>Quân huy</label>
                        <input class="form-control" name="txtQh" value="{!! old('txtQh',isset($product) ? $product['qh'] : null) !!}"/>
                    </div>
                    <div class="form-group">
                        <label>Rank</label>
                        <select name="txtRank" class="form-control">
                            <option @if(old('txtRank',isset($product) ? $product['rank'] : null)==1) selected @endif value="1">Đồng</option>    
                            <option @if(old('txtRank',isset($product) ? $product['rank'] : null)==2) selected @endif value="2">Bạc</option>   
                            <option @if(old('txtRank',isset($product) ? $product['rank'] : null)==3) selected @endif value="3">Vàng</option>   
                            <option @if(old('txtRank',isset($product) ? $product['rank'] : null)==4) selected @endif value="4">Kim Cương</option>  
                            <option @if(old('txtRank',isset($product) ? $product['rank'] : null)==5) selected @endif value="5">Cao Thủ</option>       
                            <option @if(old('txtRank',isset($product) ? $product['rank'] : null)==6) selected @endif value="6">Thách đấu</option>               
                        </select>
                    </div>
                    @foreach($product_atr_cate as $key=> $value)
                        <h3 style="color: maroon;">{{ $value['name'] }}</h3>
                        <div style="width: 100%; float:left; margin-bottom: 20px;">
                        @foreach($value['product_atr_list'] as $k=>$v)
                            <div style="float: left; width:30%;">
                                <label style="cursor: pointer;"><input name="product_atr_list[]" type="checkbox" value="{{ $v['id'] }}" <?php if($v['select']==1) echo "checked='checked'"; ?> /> {{ $v['name'] }}</label>
                            </div>    
                        @endforeach
                        </div>
                    @endforeach
                    <div class="form-group">
                        <label>Product Status</label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="1" type="radio" <?php if($product['status']==1) echo "checked='checked'"; ?>>Visible
                        </label>
                        <label class="radio-inline">
                            <input name="rdoStatus" value="0" type="radio" <?php if($product['status']==0) echo "checked='checked'"; ?>>Invisible
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Product Edit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                
            </div>
            <div class="col-lg-4 col-lg-offset-1">
                <?php
                    $stt = 1;
                ?>
                @foreach($product_image as $value)
                    <div class="form-group" id="{!! $value['id'] !!}">
                        <label>Hình {!! $stt !!}</label>
                        <img id="{!! $value['id'] !!}" src="{!! asset('resources/upload/details/'.$value['images']) !!}" class="image_current">
                        <button onclick="xacnhanxoa();" type="button" class="btn btn-circle btn-danger btn-close"><a class="button-close" href="javascript:void(0)"><i class="fa fa-close"></i></a></button>
                        <input class="addImage" type="file" name="fProductImage[]">
                    </div>   
                    <?php $stt++; ?>                
                @endforeach
                    <div class="form-group">
                        <button type="button" class="btn btn-info" id="fImage">Add more images</button>
                        <div id="insert"></div>
                    </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<form>
<!-- /#page-wrapper -->
@endsection