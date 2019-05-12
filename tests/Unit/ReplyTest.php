<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
   /* public function test_a_user_has_an_owner()
    {
        $reply = factory('App\Reply')->create(); // 创建回复

        $this->assertInstanceOf('App\User', $reply->owner);
    }*/

    /*public function test_it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }*/

    public function test_it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = create('App\Reply',[
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe','JohnDoe'],$reply->mentionedUsers());
    }
}
