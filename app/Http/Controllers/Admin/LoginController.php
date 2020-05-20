<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Org\code\Code;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //后台登录页
    public function login(){
        return view('admin.login');
    }

    //手功添加的验证码类
    public function code(){
        $code = new Code();
        $code->make();
    }

    //grepwar/captcha验证码插件
    public function captcha($tmp){
        $phrase = new PhraseBuilder;    // 设置验证码位数
        $code = $phrase->build(6);    // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);    // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);    // 可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);// 获取验证码的内容
        $phrase = $builder->getPhrase();    // 把内容存入session
        \Session::flash('code', $phrase);    // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:p_w_picpath/jpeg");
        $builder->output();
    }

    //处理用户登录方法
    public function doLogin(Request $request)
    {
        //1.接收表单揭交的数据
        $input = $request->except('_token');

        //验证规则
        $rule = [
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash'
        ];

        //提示信息
        $msg = [
            'username.required'=>'用户名必须输入',
            'username.between'=>'用户名长度必须在4-18位之间',
            'password.required'=>'密码必须输入',
            'password.between'=>'密码长度必须在4-18位之间',
            'password.alpha_dash'=>'密码必须是数字、字母、下划线'
        ];

        //2.表单验证，直接copy手册中的手动验证代码
        $validator = Validator::make($input, $rule, $msg);

        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }

        //验证码
        if(strtolower($input['code']) != strtolower(session()->get('code'))){
            return redirect('admin/login')->with('errors','验证码错误');
        }

        //3.验证用户的存在
        $user = User::where('user_name',$input['username'])->first();

        if(!$user){
            return redirect('admin/login')->with('errors','用户名为空');
        }

        if($input['password'] != Crypt::decrypt($user->user_pass)){
            return redirect('admin/login')->with('errors','密码错误');
        }

        //4.保存用户信息到session中
        session()->put('user',$user);

        //5.跳转到后台首页
        return redirect('admin/index');
    }

    public function jiami()
    {
        //1.md5加密，生成32位的字符串，字串一一对应.给密码加个盐值
//        $str = 'salt'.'123456';
//        return md5($str);

        //2.哈希加密,生成65位字符串，每次刷新都不一样
//        $str = '123456';
//        $hash = Hash::make($str);
//        Hash::check('要验证的表单密码','数据库中取出的密码')；
//        if(Hash::check($str,$hash)){
//            return "密码正确";
//        }else{
//            return '密码错误';
//        }

        //3.crypt加密,生成255位字符串
        $str = '123456';
        $encrypt_str = 'eyJpdiI6Ik4zem1tWVBcLzJRMGZtcGtSWmRvdGtnPT0iLCJ2YWx1ZSI6IkZwQXMxb0FXR21qSEEzMDNWbEt1QXc9PSIsIm1hYyI6Ijk3YjJiYTExYTNkOTJhNjljNjc5ODQzOTY0YjQ2YjcwZjZiY2Q0ODcyMjJiOTIwMmFlZDFkODZjYmU0ZmZjYjUifQ';
//        return Crypt::encrypt($str);
        if(Crypt::decrypt($encrypt_str)==$str){
            return '密码正确';
        }
    }

    public function index()
    {
        return view('admin.index');
    }

    public function welcome()
    {
        return view('admin.welcome');
    }
}
