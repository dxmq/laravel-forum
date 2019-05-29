<?php

namespace App\Http\Controllers;

use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Fan;

class UsersController extends Controller
{
    // 验证邮箱
    public function sendVerificationMail()
    {
        $user = Auth::user();
        Mail::to($user)->send(new PleaseConfirmYourEmail($user));

        return redirect('/threads')->with('flash', '验证邮件已发送到您的注册邮箱上，请注意查收。');
    }

    // 关注
    public function fan($id)
    {
        // fan_id, star_id
        Fan::firstOrCreate(['fan_id' => Auth::id(), 'star_id' => $id]);
        $arr = [
            'error' => 0,
            'message' => '',
        ];

        return json_encode($arr);
    }

    // 取消关注
    public function unfan($id)
    {
        // fan_id, star_id
        Auth::id();
        Fan::where('fan_id', Auth::id())->where('star_id', $id)->delete();

        return [
            'error' => 0,
            'message' => '',
        ];
    }
}
