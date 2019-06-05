<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelSocialite\Socialite;
use App\User;

class GithubController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $github_user = Socialite::driver('github')->user();

        // 判断用户是否登录过
        $countMap = [
            'provider' => $github_user->getProviderName(),
            'openid' => $github_user->getId(),
        ];

        $user = User::where($countMap)->first();

        if (!$user) {
            try {
                $user = User::create([
                    'name' => $github_user->getUserName(),
                    'slug' => $github_user->getUserName(),
                    'email' => $github_user->getEmail(),
                    'avatar_path' => $github_user->getAvatar(),
                    'provider' => $github_user->getProviderName(),
                    'openid' => $github_user->getId(),
                    'password' => bcrypt(str_random(6)),
                    'confirmed' => 1,
                ]);
            } catch (\Exception $e) {
                return redirect()
                    ->guest('/login')
                    ->with('flash', '名字或邮箱在本站已使用过！请使用之前的方式登录！');
            }
        }

        Auth::login($user);
        return redirect()
            ->guest('/')
            ->with('flash', '登录成功！');
    }
}