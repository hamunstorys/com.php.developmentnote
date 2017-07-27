<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RemindController extends Controller
{
    public function create()
    {
        return view('auth.remind');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users|max:320'
        ]);

        $email = $request->get('email');
        $token = str_random(64);

        if (DB::table('password_resets')->where('email', '=', $email) == null) {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        } else {
            DB::table('password_resets')->where('email', '=', $email)->update([
                'token' => $token,
            ]);
        }

        Mail::send('auth.emails.reset', compact('token'), function ($message) use ($email) {
            $message->to($email);
            $message->subject(sprintf('[%s] 비밀번호를 초기화하세요.', config('app.name'))
            );
        });

        flash('비밀번호를 바꾸는 방법을 담은 이메일을 발송했습니다. 이메일을 확인해주세요.');
        return redirect()->route('index');
    }
}
