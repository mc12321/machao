<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//登录
Route::get('/admin/login', 'Admin\LoginController@login');        //登录
Route::post('/admin/login', 'Admin\LoginController@loginPost');   //post登录请求
Route::get('/admin/loginout', 'Admin\LoginController@loginout');  //注销

Route::group(['prefix' => 'admin', 'middleware' => ['admin.checkLogin']], function () {
    //首页
    Route::get('/', 'Admin\IndexController@index');       //首页
    Route::get('/index', 'Admin\IndexController@index');  //首页
    //概览页面
//    Route::get('/overview/index', 'Admin\OverViewController@index');       //首页
    //管理员管理
    Route::any('/admin/index', 'Admin\AdminController@index');  //管理员管理首页
    Route::get('/admin/setStatus/{id}', 'Admin\AdminController@setStatus');  //设置管理员状态
    Route::get('/admin/edit', 'Admin\AdminController@edit');  //新建或编辑管理员
    Route::post('/admin/edit', 'Admin\AdminController@editPost');  //新建或编辑管理员
    Route::get('/admin/editMySelf', ['as' => 'editMySelf', 'uses' => 'Admin\AdminController@editMySelf']);  //修改个人资料get
    Route::post('/admin/editMySelf', 'Admin\AdminController@editMySelfPost');  //修改个人资料post


    //用户管理
    Route::any('/user/index', 'Admin\UserController@index');  //用户管理
    Route::get('/user/setStatus/{id}', 'Admin\UserController@setStatus');  //设置用户状态
    Route::get('/user/detail', 'Admin\UserController@detail');  //用户详情
    Route::get('/user/setLevel/{id}', 'Admin\UserController@setLevel');  //设置用级别

    //用户关注
    Route::any('/guanzhu/index', 'Admin\GuanZhuController@index');  //用户关注表
    Route::get('/guanZhu/setGuanZhu', 'Admin\GuanZhuController@setGuanZhu'); //取消关注设置


    //轮播图管理
    Route::any('/ad/index', 'Admin\ADController@index');  //轮播图管理搜索
    Route::get('/ad/edit', 'Admin\ADController@edit');  //轮播图管理添加、编辑-get
    Route::post('/ad/edit', 'Admin\ADController@editPost');  //轮播图管理添加、编辑-post
    Route::get('/ad/setStatus/{id}', 'Admin\ADController@setStatus');  //设置轮播图状态
    Route::get('/ad/del/{id}', 'Admin\ADController@del');  //删除广告图

    //作品管理
    Route::get('/article/index', 'Admin\ArticleController@index');  //作品管理首页
    Route::get('/article/setStatus/{id}', 'Admin\ArticleController@setStatus');  //设置图文状态
    Route::get('/article/edit', 'Admin\ArticleController@edit');  //添加 修改图文标题
    Route::post('/article/edit', 'Admin\ArticleController@editPost');  //添加 修改图文标题
    Route::get('/article/recovery', 'Admin\ArticleController@recovery');  //文章回收站


    //图文详情
    Route::get('/article/detail', 'Admin\ArticleController@detail');  //图文详情
    Route::post('/article/detail', 'Admin\ArticleController@detailPost');  //图文详情 编辑
    Route::get('/article/info', 'Admin\ArticleController@info');  //文章详情信息
    Route::get('/article/del', 'Admin\TWStepController@delDetail');  //删除示例详情信息
    Route::get('/article/delwz', 'Admin\ArticleController@delDetailWz');  //删除文章
    Route::get('/article/ewm', 'Admin\ArticleController@ewm');  //获取文章的小程序二维码
    Route::get('/article/regain', 'Admin\ArticleController@regain');  //恢复删除的文章

    //分享图片管理
    Route::get('/showpic/index', 'Admin\ShowPicController@index');  //图文详情
    Route::get('/showpic/setStatus/{id}', 'Admin\ShowPicController@setStatus');  //设置分享图状态
    Route::get('/showpic/edit', 'Admin\ShowPicController@edit');  //新建或编辑图片
    Route::post('/showpic/edit', 'Admin\ShowPicController@editPost');  //图片管理添加、编辑-post
});













