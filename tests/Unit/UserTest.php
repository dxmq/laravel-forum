<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /*public function test_a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('App\User');

        $reply = create('App\Reply', ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }*/

    public function test_a_user_can_determine_their_avatar_path()
    {
        $user = create('App\User');

        $this->assertEquals('avatars/default.png',$user->avatar());

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals('avatars/me.jpg',$user->avatar());
    }
}
