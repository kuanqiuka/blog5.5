<?php

namespace App\Http\Controllers\Admin;

use App\Org\code\Code;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
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

        //3.验证用户的存在

        //4.存到session中

        //5.跳转到后台首页

    }
}
