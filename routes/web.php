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



Route::group(['prefix' => 'html5', 'middleware' => ['wechat.oauth']], function () {
    //首页
    Route::get('index', 'Admin\ViewController@index');
});













