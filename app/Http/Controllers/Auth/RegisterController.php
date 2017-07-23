<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $confirmCode = str_random(60);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'confirm_code' => $confirmCode,
        ]);

        Mail::send('auth.emails.confirm', compact('user'), function ($message) use ($user) {
            $message->to($user->email);
            $message->subject(sprintf('[%s] 회원 가입을 확인해주세요.', config('app.name'))
            );
        });

        $this->respondCreated('가입하신 메일 계정으로 가입 확인 메일을 보내드렸습니다. 가입 확인하시고 로그인해주세요.');
    }

    public function confirm($code)
    {
        $user = User::whereConfirmCode($code)->first();
        if (!$user) {
            flash('URL이 정확하지 않습니다.');
            return redirect()->route('index');
        }

        $user->activated = 1;
        $user->confirm_code = null;
        $user->save();

        $this->respondCreated('가입 확인되었습니다.');
    }

    public function respondCreated($message)
    {
        flassh($message);
        return redirect()->route('index');
    }
}
