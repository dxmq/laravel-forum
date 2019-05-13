<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /*public function test_a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        event(new Registered(create('App\User')));

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }*/

    public function test_user_can_fully_confirm_their_email_addresses()
    {
        $this->post('/register',[
            'name' => 'NoNo1',
            'email' => 'NoNo1@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        $user = User::whereName('NoNo1')->first();

        // 新注册用户未认证，且拥有 confirmation_token
        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $response = $this->get('/register/confirm?token=' . $user->confirmation_token);

        // 当新注册用户点击认证链接，用户变成已认证，且跳转到话题列表页面
        $this->assertTrue($user->fresh()->confirmed);
        $response->assertRedirect('/threads');
    }
}
