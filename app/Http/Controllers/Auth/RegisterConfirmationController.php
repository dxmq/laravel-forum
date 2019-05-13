<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))
            ->first();

        if ( ! $user) {
            return redirect(route('threads'))
                ->with('flash', 'Unknown token.');
        }

        $user->confirm();

        return redirect('/threads')
            ->with('flash', '您的帐户现已确认！你可以发帖到论坛。');
    }
}
