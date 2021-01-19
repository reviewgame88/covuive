<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Khóa Học Lập Trình Laravel Framework 5.x Tại Khoa Phạm">
    <meta name="author" content="Vu Quoc Tuan">
    <title>Administrator</title>

    <!-- Bootstrap Core CSS -->
    <link href="{!! URL('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{!! URL('public/admin/bower_components/metisMenu/dist/metisMenu.min.css') !!}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{!! URL('public/admin/dist/css/sb-admin-2.css') !!}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{!! URL('public/admin/bower_components/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="{!! URL('public/admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') !!}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{!! URL('public/admin/bower_components/datatables-responsive/css/dataTables.responsive.css') !!}" rel="stylesheet">

    <!-- ckeditor and ckfinder -->
    <script src="{!! URL('public/admin/ckeditor/ckeditor.js') !!}"></script>

    <script src="{!! URL('public/admin/ckfinder/ckfinder.js') !!}"></script>

    <script type="text/javascript">
        var baseURL = "{!! URL('/') !!}";
    </script>

    <script src="{!! URL('public/func_ckfinder.js') !!}"></script>
    <!-- End ckeditor and ckfinder -->

    <link rel="stylesheet" type="text/css" href="{!! URL('public/admin/dist/css/mystyle.css'); !!}">
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <p class="navbar-brand">Administrator</p>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li><b><i>{!! Auth::user()->name !!}</i></b></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{!! URL('auth/logout') !!}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Category<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!! route('admin.cate.getList') !!}">List Category</a>
                                </li>
                                <li>
                                    <a href="{!! route('admin.cate.getAdd') !!}">Add Category</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-cube fa-fw"></i> Product<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!! route('admin.product.getList') !!}">List Product</a>
                                </li>
                                <li>
                                    <a href="{!! route('admin.product.getAdd') !!}">Add Product</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-cube fa-fw"></i> Product Atribute Category<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!! route('admin.product_atr_cate.getList') !!}">List Product Atribute Cate</a>
                                </li>
                                <li>
                                    <a href="{!! route('admin.product_atr_cate.getAdd') !!}">Add Product Atribute Cate</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-cube fa-fw"></i> Product Atribute<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{!! route('admin.ProductAtribute.getList') !!}">List Product Atribute</a>
                                </li>
                                <li>
                                    <a href="{!! route('admin.ProductAtribute.getAdd') !!}">Add Product Atribute</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> User<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a  href="{!! route('admin.user.getList') !!}">List User</a>
                                </li>
                                <li>
                                    <a  href="{!! route('admin.user.getAdd') !!}">Add User</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Thẻ nạp<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a  href="{!! route('admin.CheckCard.getList') !!}">Danh sách thẻ</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        @yield('content')
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{!! URL('public/admin/bower_components/jquery/dist/jquery.min.js') !!}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{!! URL('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{!! URL('public/admin/bower_components/metisMenu/dist/metisMenu.min.js') !!}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{!! URL('public/admin/dist/js/sb-admin-2.js') !!}"></script>

    <!-- DataTables JavaScript -->
    <script src="{!! URL('public/admin/bower_components/DataTables/media/js/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! URL('public/admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') !!}"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script src="{!! URL('public/admin/js/myScript.js') !!}"></script>
</body>

</html>
