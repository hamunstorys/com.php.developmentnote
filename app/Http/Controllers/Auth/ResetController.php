<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{
    public function create($token = null)
    {
        return view('auth.reset', compact('token'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users|max:320',
            'password' => 'required|confirmed|max:255',
            'token' => 'required'
        ]);

        $token = $request->get('token');

        if (!DB::table('password_resets')->whereToken($token)->first()) {
            flash('URL이 정확하지 않습니다.');
            return back()->withInput();
        }

        User::whereEmail($request->input('email'))->first()->update([
            'password' => bcrypt($request->input('password'))
        ]);

        DB::table('password_resets')->whereToken($token)->delete();
        flash('비밀번호를 바꾸었습니다. 새로운 비밀번호로 로그인하세요.');
        return redirect()->route('index');
    }
}
