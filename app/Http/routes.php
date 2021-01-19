<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index' );

Route::post('search',['as'=>'search','uses'=>'WelcomeController@postSearch']);

Route::group(['prefix'=>'admin','middleware'=>['auth','admin']],function(){

    Route::group(['prefix'=>'cate'],function(){

        Route::get('list',['as'=>'admin.cate.getList','uses'=>'CateController@getList']);
        Route::get('add',['as'=>'admin.cate.getAdd','uses'=>'CateController@getAdd']);
        Route::post('add',['as'=>'admin.cate.postAdd','uses'=>'CateController@postAdd']);

        Route::get('delete/{id}',['as'=>'admin.cate.getDelete','uses'=>'CateController@getDelete']);
        Route::get('edit/{id}',['as'=>'admin.cate.getEdit','uses'=>'CateController@getEdit']);
        Route::post('edit/{id}',['as'=>'admin.cate.postEdit','uses'=>'CateController@postEdit']);

    });
    
     Route::group(['prefix'=>'atr-cate'],function(){

        Route::get('list',['as'=>'admin.product_atr_cate.getList','uses'=>'ProductAtributeCate@getList']);
        Route::get('add',['as'=>'admin.product_atr_cate.getAdd','uses'=>'ProductAtributeCate@getAdd']);
        Route::post('add',['as'=>'admin.product_atr_cate.postAdd','uses'=>'ProductAtributeCate@postAdd']);

        Route::get('delete/{id}',['as'=>'admin.product_atr_cate.getDelete','uses'=>'ProductAtributeCate@getDelete']);
        Route::get('edit/{id}',['as'=>'admin.product_atr_cate.getEdit','uses'=>'ProductAtributeCate@getEdit']);
        Route::post('edit/{id}',['as'=>'admin.product_atr_cate.postEdit','uses'=>'ProductAtributeCate@postEdit']);

    });

    Route::group(['prefix'=>'product'],function(){

        Route::get('list',['as'=>'admin.product.getList', 'uses' => 'ProductController@getList']);

        Route::get('add',['as'=>'admin.product.getAdd', 'uses'=>'ProductController@getAdd']);
        Route::post('add',['as'=>'admin.product.postAdd', 'uses'=>'ProductController@postAdd']);

        Route::get('delete/{id}',['as'=>'admin.product.getDelete','uses'=>'ProductController@getDelete']);

        Route::get('edit/{id}',['as'=>'admin.product.getEdit','uses'=>'ProductController@getEdit']);
        Route::post('edit/{id}',['as'=>'admin.product.postEdit','uses'=>'ProductController@postEdit']);

        Route::get('delImg/{id}',['as'=>'admin.product.getDelImg','uses'=>'ProductController@getDelImg']);
    });
    
    Route::group(['prefix'=>'product-atr'],function(){

        Route::get('list',['as'=>'admin.ProductAtribute.getList', 'uses' => 'ProductAtrController@getList']);

        Route::get('add',['as'=>'admin.ProductAtribute.getAdd', 'uses'=>'ProductAtrController@getAdd']);
        Route::post('add',['as'=>'admin.ProductAtribute.postAdd', 'uses'=>'ProductAtrController@postAdd']);

        Route::get('delete/{id}',['as'=>'admin.ProductAtribute.getDelete','uses'=>'ProductAtrController@getDelete']);

        Route::get('edit/{id}',['as'=>'admin.ProductAtribute.getEdit','uses'=>'ProductAtrController@getEdit']);
        Route::post('edit/{id}',['as'=>'admin.ProductAtribute.postEdit','uses'=>'ProductAtrController@postEdit']);


    });

    Route::group(['prefix'=>'user'],function(){

        Route::get('list',['as'=>'admin.user.getList', 'uses' => 'UserController@getList']);

        Route::get('add',['as'=>'admin.user.getAdd', 'uses'=>'UserController@getAdd']);
        Route::post('add',['as'=>'admin.user.postAdd', 'uses'=>'UserController@postAdd']);

        Route::get('delete/{id}',['as'=>'admin.user.getDelete','uses'=>'UserController@getDelete']);

        Route::get('edit/{id}',['as'=>'admin.user.getEdit','uses'=>'UserController@getEdit']);
        Route::post('edit/{id}',['as'=>'admin.user.postEdit','uses'=>'UserController@postEdit']);


    });
    
    Route::group(['prefix'=>'check-card'],function(){

        Route::get('list',['as'=>'admin.CheckCard.getList', 'uses' => 'CheckCard@getList']);
        
        Route::get('add',['as'=>'admin.CheckCard.getAdd', 'uses'=>'CheckCard@getAdd']);
        Route::post('add',['as'=>'admin.CheckCard.postAdd', 'uses'=>'CheckCard@postAdd']);

        Route::get('delete/{id}',['as'=>'admin.CheckCard.getDelete','uses'=>'CheckCard@getDelete']);

        Route::get('edit/{id}',['as'=>'admin.CheckCard.getEdit','uses'=>'CheckCard@getEdit']);
        Route::post('edit/{id}',['as'=>'admin.CheckCard.postEdit','uses'=>'CheckCard@postEdit']);


    });
    

});

Route::get('co-tuong-online',['as'=>'chineseChessOnline','uses'=>'WelcomeController@show_chinese_chess']);

Route::get('loai-san-pham/{id}/{alias}',['as'=>'loaisanpham','uses'=>'WelcomeController@loaisanpham']);

Route::get('san-pham/{id}/{alias}',['as'=>'sanpham','uses'=>'WelcomeController@sanpham']);

Route::get('lien-he',['as'=>'getLienhe','uses'=>'WelcomeController@getLienHe']);
Route::post('lien-he',['as'=>'postLienhe','uses'=>'WelcomeController@postLienHe']);

Route::get('mua-hang/{id}',['as'=>'muahang','uses'=>'WelcomeController@muaHang']);

Route::get('gio-hang',['as'=>'giohang','uses'=>'WelcomeController@gioHang']);

Route::get('xoasanpham/{id}',['as'=>'xoasanpham','uses'=>'WelcomeController@xoaSanPham']);

Route::get('capnhatsp/{id}',['as'=>'capnhatsp','uses'=>'WelcomeController@capNhatSp']);

Route::get('dang-ki',['as'=>'getDangki','uses'=>'WelcomeController@getRegister']);

Route::post('dang-ki',['as'=>'postDangki','uses'=>'WelcomeController@postRegister']);

Route::get('dang-nhap',['as'=>'getDangnhap','uses'=>'WelcomeController@getLogin']);

Route::post('dang-nhap/',['as'=>'postDangnhap','uses'=>'WelcomeController@postLogin']);

Route::get('logout',['as'=>'logout','uses'=>'WelcomeController@logout']);

Route::get('search',['as'=>'search','uses'=>'WelcomeController@postSearch']);

Route::get('/redirect/{social}', 'SocialAuthController@redirect');
Route::get('/callback/{social}', 'SocialAuthController@callback');

Route::get('nap-the',['as'=>'getNapThe','uses'=>'WelcomeController@getNapThe']);

Route::post('nap-the',['as'=>'postNapThe','uses'=>'WelcomeController@postNapThe']);

Route::get('buyacc/{id}',['as'=>'getBuyAcc','uses'=>'WelcomeController@getBuyAcc']);

Route::get('lich-su',['as'=>'getLichSu','uses'=>'WelcomeController@getLichSu']);

Route::get('check-nap-the',['as'=>'getCheckNapThe','uses'=>'WelcomeController@getCheckNapThe']);

Route::get('test-form',function(){
    return view('user.pages.product');
});

