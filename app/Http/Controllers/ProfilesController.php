<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $profileUser = User::withCount(['stars', 'fans', 'posts', 'threads'])->find($user->id);

        $threads = $user->threads()->paginate(10);

        $replies = $user->replies()->paginate(10);

        $posts = $user->posts()->paginate(10);

        return view('profiles.show', [
            'profileUser' => $profileUser,
            'activities' => Activity::feed($user),
            'threads' => $threads,
            'replies' => $replies,
            'posts' => $posts,
        ]);
    }

    public function update(User $user)
    {
        if (!empty(request('origin_password'))) {
            request()->validate([
                'name' => 'required|max:255',
                'origin_password' => 'required',
                'password' => 'required|min:8|confirmed',
                'description' => 'max:200'
            ]);

            if (!Hash::check(request('origin_password'), $user->password)) {
                return back()->with('flash', '原密码输入错误！');
            }

            $user->update(array_merge(request(['name', 'description']), ['password' => bcrypt(request('password'))]));

        } else {
            request()->validate([
                'name' => 'required|max:255',
                'description' => 'max:200'
            ]);

            $user->update(array_merge(request(['name', 'description']), ['slug' => request('name')]));
        }

        return redirect('/profiles/' . $user->slug)->with('flash', '资料修改成功！');
    }
}
