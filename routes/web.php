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

//后台登录的路由
Route::get('admin/login','Admin\LoginController@login');

//验证码路由
Route::get('admin/code','Admin\LoginController@code');

Route::get('/code/captcha/{tmp}', 'Admin\LoginController@captcha');

Route::post('admin/doLogin','Admin\LoginController@doLogin');





