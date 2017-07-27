<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:320',
            'password' => 'required|min:6|max:255'
        ]);

        if (!auth()->attempt($request->only('email', 'password'), $request->has('remember'))) {
            flash('이메일 또는 비밀번호가 맞지 않습니다.');
            return back()->withInput();
        }

        if (!auth()->user()->activated) {
            auth()->logout();
            flash('정상적으로 가입절차가 완료 되었는 지 확인해주세요.');
            return back()->withInput();
        }

        flash('로그인 되었습니다!');
        return redirect()->route('index');

    }

    public function destroy()
    {
        auth()->logout();
        flash('로그아웃 되었습니다.');
        return redirect()->route('index');
    }
}

