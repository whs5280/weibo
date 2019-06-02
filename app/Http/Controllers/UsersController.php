<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    //中间件
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show','create','store','index','confirmEmail']
        ]);

        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    /*
     * 显示所有用户列表的页面
     */
    public function index()
    {
        //$users = User::all();
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    /*
     * 显示用户个人信息的页面
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /*
     * 创建用户的页面
     */
    public function create()
    {
        return view('users.create');
    }

    /*
     * 创建用户
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:25',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6',
        ]);

        $name = $request->input('name','');
        $email = $request->input('email','');
        $password = $request->input('password','');

        $date = [
          'name' => $name,
          'email' => $email,
          'password' => Hash::make($password),
        ];

        $user = User::create($date);

        //发送邮件
        $this->sendEmailConfirmationTo($user);
        return redirect('signup');
    }

    /*
     * 编辑用户个人资料的页面
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /*
     * 更新用户
     */
    public function update(User $user,Request $request)
    {
        $this->authorize('update', $user);

        $this->validate($request,[
            'name' => 'required|max:25',
            'password' => 'required|confirmed|min:6',
        ]);

        $name = $request->input('name','');
        $password = $request->input('password','');

        $date = [
            'name' => $name,
            'password' => Hash::make($password),
        ];

        $user->update($date);
        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.edit',$user->id);
    }

    /*
     * 删除用户
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
    }

    /*
     * 发送邮件
     */
    public function sendEmailConfirmationTo($user)
    {

        $url = 'http://www.weibo.test:8080/signup/confirm/'.$user->activation_token;
        $to = $user->email;
        $subject = '感谢注册 Weibo 应用！请确认你的邮箱。';

        Mail::send('emails.confirm',['url'=>$url],function ($message) use ($to,$subject){

            $message->to($to)->subject($subject);
        });

        if(count(Mail::failures()) < 1){

            session()->flash('success','邮件已经发生，请查看您的邮箱~');
            //return redirect('login');
        }else{

            //加入队列一直发送
            session()->flash('error','网络出现了问题，邮件正在发送~');
        }

    }

    /*
     * 邮箱激活
     */
    public function confirmEmail($token){

        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->email_verified_at = now();
        $user->activation_token = null;
        $user->save();

        //注册成功自动登陆
        Auth::login($user);
        session()->flash('success','恭喜你，激活成功！');
        return redirect()->route('users.show',[$user]);
    }
}
