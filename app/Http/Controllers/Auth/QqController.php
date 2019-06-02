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
        return Socialite::driver('qq')->redirect();
    }

    public function handleProviderCallback()
    {
        $qq_user = Socialite::driver('qq')->user();

        $user = User::where('qq_name', $qq_user->getUserName())->first();
        if (empty($user)) {
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
        }
        Auth::login($user);
        return Redirect()->guest('/');
    }
}