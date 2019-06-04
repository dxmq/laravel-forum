<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelSocialite\Socialite;
use App\User;

class QqController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('qq')->redirect();
    }

    public function handleProviderCallback()
    {
        $qq_user = Socialite::driver('qq')->user();

        $user = User::where('qq_name', $qq_user->getUserName())->first();

        if (!$user->exists) {
            try {
                $user = User::create([
                    'name' => $qq_user->getUserName(),
                    'slug' => $qq_user->getUserName(),
                    'email' => $qq_user->getEmail(),
                    'avatar_path' => $qq_user->getAvatar(),
                    'qq_name' => $qq_user->getUserName(),
                    'provider' => $qq_user->getProviderName(),
                    'password' => bcrypt(str_random(6)),
                    'confirmed' => 1,
                ]);
            } catch (\Exception $e) {
                return redirect()
                    ->guest('/')
                    ->with('flash', 'QQ邮箱在本站已使用过！请使用当前的邮箱的其他方式登录！');
            }
        }
        Auth::login($user);
        return redirect()
            ->guest('/')
            ->with('flash', '登录成功');
    }
}