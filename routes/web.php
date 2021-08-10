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

Route::get('/', function () {
    return 'hello';
});

/*****************************
 *
 *
测试路由
 *
 *
 *****************************/

Route::get('index/testLogin', 'TestController@testLogin');

Route::post('index/testGetSession', 'TestController@testGetSession');


/*****************************
 *
 *
项目路由
 *
 *
*****************************/

/*********************
登录页面
 *********************/
Route::get('index/login','MessageBoardController@login')->name('MessageBoard.login');

/*********************
登录完成页面
 *********************/
Route::post('index/loginOver', 'MessageBoardController@loginOver');

/*********************
注册页面
 *********************/
Route::get('index/register', 'MessageBoardController@register');

/*********************
留言页面
 *********************/
Route::get('index/leavingMessage', 'MessageBoardController@leavingMessage')->middleware('usercheck');

/*********************
注册完毕页面
 *********************/
Route::post('index/registerOver', 'MessageBoardController@registerOver')->middleware('usercheck');

/*********************
留言完毕页面
 *********************/
Route::post('index/leavingMessageOver', 'MessageBoardController@leavingMessageOver');

/*********************
查看所有留言页面
 *********************/
Route::get('index/viewMessage', 'MessageBoardController@viewMessage')->name('MessageBoard.viewMessage');

/*********************
查看我自己的留言页面
 *********************/
Route::get('index/viewMyselfMessage', 'MessageBoardController@viewMyselfMessage');

/*********************
注销页面
 *********************/
Route::get('index/cancellation', 'MessageBoardController@cancellation');

/*********************
注销完毕页面
 *********************/
Route::post('index/cancellationOver', 'MessageBoardController@cancellationOver')->middleware('usercheck');

/*********************
删除留言页面
 *********************/
Route::get('index/deleteMessage', 'MessageBoardController@deleteMessage');

/*********************
编辑留言页面
 *********************/
Route::post('index/updateMessage', 'MessageBoardController@updateMessage');

/*********************
编辑留言完成页面
 *********************/
Route::post('index/updateMessageOver', 'MessageBoardController@updateMessageOver');

/*********************
评论页面
 *********************/
Route::get('index/commentMessage', 'MessageBoardController@commentMessage');

/*********************
评论开始页面
 *********************/
Route::post('index/commentBegin', 'MessageBoardController@commentBegin');

/*********************
评论完成页面
 *********************/
Route::post('index/commentMessageOver', 'MessageBoardController@commentMessageOver');

/*********************
退出
 *********************/
Route::get('index/quit', 'MessageBoardController@quit');






Route::get('index/video/test', 'BaiduVideoController@useVideo');
Route::get('index/receiveVideo', 'BaiduVideoController@receiveVideo');
Route::post('index/receiveVideoOver', 'BaiduVideoController@receiveVideoOver');







