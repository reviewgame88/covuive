@extends('admin.master')
@section('content')
<!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <form enctype="multipart/form-data" name="test" action="{!! route('admin.product.postAdd') !!}" method="POST">
            {!! csrf_field() !!}        
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Product
                        <small>Add</small>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-7" style="padding-bottom:120px">
                        <div class="form-group">
                            <label>Category Parent</label>
                            <select name="cateParent" class="form-control">
                                <option value="">Please Choose Category</option>
                                <?php cateParent($parent,0,"--", old('cateParent'));   ?>
                            </select>
                            <h3 class="label label-danger">{{ $errors->first('cateParent') }}</h3><br/>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" name="txtName" placeholder="Please Enter Product's Name" value="{!! old('txtName') !!}" /><br/>
                             <h3 class="label label-danger">{{ $errors->first('txtName') }}</h3>                  
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input class="form-control" name="txtPrice" placeholder="Please Enter Product's Price" value="{!! old('txtPrice') !!}"/>
                        </div>
                        <div class="form-group">
                            <label>Price Atm</label>
                            <input class="form-control" name="txtPriceAtm" placeholder="Please Enter Product's Price" value="{!! old('txtPriceAtm') !!}"/>
                        </div>
                    <div class="form-group">
                        <label>Sale Off</label>
                        <input class="form-control" name="txtSaleOff" placeholder="Please Enter Product's Price" value="{!! old('txtSaleOff') !!}"/>
                    </div>
                        <div class="form-group">
                            <label>Intro</label>
                            <textarea class="form-control" rows="3" name="txtIntro">{!! old('txtIntro') !!}</textarea>
                            <script type="text/javascript">
                                ckeditor("txtIntro");
                            </script>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="form-control" rows="3" name="txtContent">{!! old('txtContent') !!}</textarea>
                            <script type="text/javascript">
                                ckeditor("txtContent");
                            </script>
                        </div>
                        <div class="form-group">
                            <label>Images</label>
                            <input type="file" name="fImages"><br/>
                            <h3 class="label label-danger">{{ $errors->first('fImages') }}</h3>
                        </div>
                        <div class="form-group">
                            <label>Product Keywords</label>
                            <input class="form-control" name="txtKeyword" placeholder="Please Enter Category Keywords" value="{!! old('txtOrder') !!}"/>
                        </div>
                        <div class="form-group">
                            <label>Product Description</label>
                            <textarea class="form-control" rows="3" name="txtDescription">{!! old('txtDescription') !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Gold</label>
                            <input class="form-control" name="txtGold" value="{!! old('txtGold') !!}"/>
                        </div>
                        <div class="form-group">
                            <label>Quân huy</label>
                            <input class="form-control" name="txtQh" value="{!! old('txtQh') !!}"/>
                        </div>
                        <div class="form-group">
                            <label>Rank</label>
                            <select name="txtRank" class="form-control">
                                <option @if(old('txtRank')==1) selected @endif value="1">Đồng</option>    
                                <option @if(old('txtRank')==2) selected @endif value="2">Bạc</option>   
                                <option @if(old('txtRank')==3) selected @endif value="3">Vàng</option>   
                                <option @if(old('txtRank')==4) selected @endif value="4">Kim Cương</option>  
                                <option @if(old('txtRank')==5) selected @endif value="5">Cao Thủ</option>       
                                <option @if(old('txtRank')==6) selected @endif value="6">Thách đấu</option>               
                            </select>
                        </div>
                        @foreach($product_atr_cate as $key=> $value)
                            <h3 style="color: maroon;">{{ $value['name'] }}</h3>
                            <div style="width: 100%; float:left; margin-bottom: 20px;">
                            @foreach($value['product_atr_list'] as $k=>$v)
                                <div style="float: left; width:30%;">
                                    <label style="cursor: pointer;"><input name="product_atr_list[]" type="checkbox" value="{{ $v['id'] }}"  @if(is_array(old('product_atr_list')) && in_array($v['id'], old('product_atr_list'))) checked @endif /> {{ $v['name'] }}</label>
                                </div>    
                            @endforeach
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label>Product Status</label>
                            <label class="radio-inline">
                                <input name="rdoStatus" value="1" checked="" type="radio" <?php if(Input::old('rdoStatus')== "1") { echo 'checked="checked"'; } ?>>Visible
                            </label>
                            <label class="radio-inline">
                                <input name="rdoStatus" value="0" type="radio" <?php if(Input::old('rdoStatus')== "2") { echo 'checked="checked"'; } ?>>Invisible
                            </label>
                        </div>
                        <button type="submit" class="btn btn-default">Product Add</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                    
                         
                    
                </div>
                <div class="col-lg-4 col-lg-offset-1">
                            @for($i=1; $i<=10; $i++)
                            <div class="form-group">
                                <label>Image {!! $i !!}</label>
                                <input type="file" name="imageGroup[]" />
                            </div>
                            @endfor
                        </div> 
            </div>
            </form>             
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
<!-- /#page-wrapper -->
@endsection