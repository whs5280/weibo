<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    /*
     * 创建登录页面
     */
    public function create()
    {
        return view('sessions.create');
    }

    /*
     * 登录功能逻辑处理
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        $email = $request->input('email','');
        $password = $request->input('password','');
        $remember_flag = $request->has('remember');

        $date = [
            'email' => $email,
            'password' => $password,
        ];

        //attempt的第一个参数就登陆的信息，第二个是记住我，参数类型为boolean
        if(Auth::attempt($date,$remember_flag)){

            //判断邮箱是否已经被激活
            if(Auth::user()->activated){

                session()->flash('success', '欢迎回来！');
                $fallback = route('users.show',[Auth::user()]);
                return redirect()->intended($fallback);
            }else{

                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('login');
            }

        }else{

            session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }

    /*
     * 注销
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出！');
        return redirect('login');
    }
}
