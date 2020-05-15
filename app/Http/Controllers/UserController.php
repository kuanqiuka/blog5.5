<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //添加方法
    //获取一个添加页面
    public function add()
    {
        return view('user.add');
    }

    //执行用户添加操作
    public function store(Request $request)
    {
        //获取客户端提交的数据
//        $input = $request->all();

        $input = $request->except('_token');
        $input['password'] = md5($request->input('password'));
        dd($input);

        //表单验证
        

    }
}
