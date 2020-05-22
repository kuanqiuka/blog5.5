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

//Route::get('/', function () {
//    return view('welcome');
//});

//用户添加路由
Route::get('user/add','UserController@add');

//用户执行添加操作路由
Route::post('user/store','UserController@store');

//用户列表页路由
Route::get('user/index',"UserController@index");

//用户修改路由
Route::get('user/edit/{id}','UserController@edit');

//用户更新路由
Route::post('user/update','UserController@update');

//用户删除路由
Route::get('/user/del/{id}','UserController@destroy');

//插件验证码路由
Route::get('/code/captcha/{tmp}', 'Admin\LoginController@captcha');

Route::group(['prefix'=>'admin','namespace'=>'Admin'], function (){
    //后台登录的路由
    Route::get('login','LoginController@login');
    //验证码路由
    Route::get('code','LoginController@code');
    Route::post('doLogin','LoginController@doLogin');
    //加密算法测试路由
    Route::get('jiami','LoginController@jiami');
});

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'], function (){
    //后台首页路由
    Route::get('index','LoginController@index');
    //后台欢迎页
    Route::get('welcome','LoginController@welcome');
    //退出登录
    Route::get('logout','LoginController@logout');
    //用户模块相关路由
    Route::resource('user','UserController');
});
