<?php

namespace App\Http\Controllers;

use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    // 验证邮箱
    public function sendVerificationMail()
    {
        $user = Auth::user();
        Mail::to($user)->send(new PleaseConfirmYourEmail($user));

        return redirect('/threads')->with('flash', '验证邮件已发送到您的注册邮箱上，请注意查收。');
    }

}
