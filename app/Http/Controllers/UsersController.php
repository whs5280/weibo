<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /*
     * 显示所有用户列表的页面
     */
    public function index()
    {

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

        //注册成功自动登陆
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        return redirect()->route('users.show',[$user]);
    }

    /*
     * 编辑用户个人资料的页面
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /*
     * 更新用户
     */
    public function update(User $user,Request $request)
    {
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
    public function destroy()
    {

    }
}
