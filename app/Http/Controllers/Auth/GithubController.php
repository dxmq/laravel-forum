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

        $user = User::where('github_name', $github_user->name)->first();
        if (empty($user)) {
            $user = User::create([
                'name' => $github_user->getUserName(),
                'slug' => $github_user->getUserName(),
                'email' => $github_user->getEmail(),
                'avatar_path' => $github_user->getAvatar(),
                'github_name' => $github_user->getName(),
                'provider' => $github_user->getProviderName(),
                'password' => bcrypt(str_random(6)),
                'confirmed' => 1,
            ]);
        }
        Auth::login($user);
        return Redirect()->guest('/');
    }
}