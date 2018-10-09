<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => '', 'middleware' => ['BeforeRequest']], function () {

    //测试接口
    Route::get('test', 'API\TestController@test');

    Route::any('serve', 'API\WechatController@serve');


});

