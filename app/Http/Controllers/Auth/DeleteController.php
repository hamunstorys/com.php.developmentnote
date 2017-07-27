<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class deleteController extends Controller
{
    public function destroy(Request $request, $id)
    {
        try {

            $this->authorize('user.authentication', $id);

        } catch (AuthorizationException $exception) {

            flash('승인되지 않은 사용자 행위입니다.');
            return redirect()->route('article.index');
        }

        $user = User::findOrFail($id)->first();
        $user->delete();
        auth()->logout();

        flash('회원탈퇴가 완료되었습니다.');
        return redirect()->route('index');
    }
}
