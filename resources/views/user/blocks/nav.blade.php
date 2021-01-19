<div id="categorymenu">
    <nav class="subnav">
        <ul class="nav-pills categorymenu">
            <li><a href="{{ URL('/') }}">Trang chủ</a></li>
            <?php
                 $cate_parent =  DB::table('cates')->select('name','id','alias')->where('parent_id',0)->get();
            ?>
            @foreach($cate_parent as $parent_item)
            <?php
                 $cate_child = DB::table('cates')->select('name','alias','id')->where('parent_id',$parent_item->id)->get();
            ?>
            <li><a href="{!! route('loaisanpham',[$parent_item->id, $parent_item->alias]) !!}">{!! $parent_item->name !!}</a>
                <!--<div>
                    <ul>
                        @foreach($cate_child as $child_item)
                        <li><a href="{!! route('loaisanpham',[$child_item->id, $child_item->alias]) !!}">{!! $child_item->name !!}</a></li>
                        @endforeach
                    </ul>
                </div>-->
            </li>
            @endforeach
            <li><a href="{{ URL('lien-he') }}">Liên hệ</a></li>
        </ul>
    </nav>
</div>