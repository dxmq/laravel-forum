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

        $fans = $user->fans()->with('fuser')->get();

        $stars = $user->stars()->with('suser')->get();

        return view('profiles.show', [
            'profileUser' => $profileUser,
            'activities' => Activity::feed($user),
            'threads' => $threads,
            'replies' => $replies,
            'posts' => $posts,
            'fans' => $fans,
            'stars' => $stars
        ]);
    }

    public function update(User $user)
    {
        if (!empty(request('origin_password'))) {
            request()->validate([
                'name' => 'required|max:255',
                'avatar' => 'image',
                'origin_password' => 'required',
                'password' => 'required|min:8|confirmed',
                'description' => 'max:200'
            ]);


            if (!Hash::check(request('origin_password'), $user->password)) {
                return back()->with('flash', '原密码输入错误！');
            }

            if (request('avatar')) {
                $avatar_path = 'storage/' . request()->file('avatar')->store('uploads/images', 'public');

                $user->update(array_merge(request(['name', 'description']), [
                    'password' => bcrypt(request('password')),
                    'avatar_path' => $avatar_path,
                    'slug' => request('name')
                ]));
            } else {
                $user->update(array_merge(request(['name', 'description']),
                    ['password' => bcrypt(request('password')), 'slug' => request('name')]));
            }

        } else {
            request()->validate([
                'name' => 'required|max:255',
                'avatar' => 'image',
                'description' => 'max:200'
            ]);

            if (request('avatar')) {
                $avatar_path = 'storage/' . request()->file('avatar')->store('uploads/avatars', 'public');

                $user->update(array_merge(request(['name', 'description']),
                    ['slug' => request('name'), 'avatar_path' => $avatar_path]));
            } else {
                $user->update(array_merge(request(['name', 'description']), ['slug' => request('name')]));
            }
        }

        return redirect('/profiles/' . $user->slug)->with('flash', '资料修改成功！');
    }
}
