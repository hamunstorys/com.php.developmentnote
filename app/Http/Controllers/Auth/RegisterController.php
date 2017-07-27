<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Authority;
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
            'email' => 'required|email|max:320|unique:users',
            'password' => 'required|min:6|max:255'
        ]);

        $confirmCode = str_random(60);

        $user = new User;
        $user->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'confirm_code' => $confirmCode,
        ]);
        $user->save();

        $authority = new Authority;
        $authority->fill([
            'articles_creatable' => 0, 'articles_updatable' => 0, 'articles_readable' => 1, 'articles_deletable' => 0,
            'comments_creatable' => 1, 'comments_updatable' => 1, 'comments_readable' => 1, 'comments_deletable' => 1
        ]);
        $user->Authorities()->save($authority);
        $authority->save();


        Mail::send('auth.emails.confirm', compact('user'), function ($message) use ($user) {
            $message->to($user->email);
            $message->subject(sprintf('[%s] 회원 가입을 확인해주세요.', config('app.name'))
            );
        });

        flash('가입하신 메일 계정으로 가입 확인 메일을 보내드렸습니다. 가입 확인하시고 로그인해주세요.');
        return redirect()->route('index');
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

        flash('가입 확인 되었습니다.');
        return redirect()->route('index');
    }

}
