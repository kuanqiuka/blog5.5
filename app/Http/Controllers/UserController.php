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

    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit',compact('user'));
    }

    public function update(Request $request)
    {
        //页面传过来的数据
        $input = $request->all();
//        dd($input);
        //数据库中对应id的记录
        $user = User::find($input['id']);
        //提交过来的用户名$input['username']替换掉原记录中的用户名
        $res = $user->update(['username'=>$input['username']]);

        if($res){
            return redirect('user/index');
        }else{
            return back();
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $res = $user->delete();

        if($res)
        {
            $data = [
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }
}
