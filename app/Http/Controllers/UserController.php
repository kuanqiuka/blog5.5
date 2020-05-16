<?php

namespace App\Http\Controllers;

use App\User;
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

        //表单验证

        //添加操作
//        User::create(['username'=>$input['username'],'password'=>$input['password']]);
        $res = User::create($input);

        if($res)
        {
            return  redirect('user/index');
        }else{
            return back();
        }
    }

    public function index()
    {
        $user = User::get();
        return view('user.list',['user'=>$user]);
    }
}
