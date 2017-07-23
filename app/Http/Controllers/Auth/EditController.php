<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('auth.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id)->first();
        $user->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password'))
        ]);

        flash('회원정보가 수정되었습니다.');
        return redirect()->route('index');
    }
}
