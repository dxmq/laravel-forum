<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;
use Laravolt\Avatar\Avatar;

class ProfilesController extends Controller
{
    public function show(User $user, Avatar $avatar)
    {
        $defaultAvatar = $avatar->create($user->name)
            ->setBackground('#00b5ad');

        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => Activity::feed($user),
            'defaultAvatar' => $defaultAvatar
        ]);
    }
}
