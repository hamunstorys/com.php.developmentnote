<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function edit(Request $request, $id)
    {
        try {

            $this->authorize('user.authentication', $id);

        } catch (AuthorizationException $exception) {

            flash('승인되지 않은 사용자 행위입니다.');
            return redirect()->route('article.index');
        }

        $user = User::findOrFail($id);
        return view('auth.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        flash('회원정보가 수정되었습니다.');
        return redirect()->route('index');
    }
}
