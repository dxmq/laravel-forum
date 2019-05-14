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

    /*public function test_it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = create('App\Reply',[
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe','JohnDoe'],$reply->mentionedUsers());
    }*/

    /*public function test_it_warps_mentioned_usernames_in_the_body_within_archor_tags()
    {

        $reply = create('App\Reply',[
            'body' => 'Hello @Jane-Doe.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>.',
            $reply->body
        );
    }*/

   /* public function test_it_knows_if_it_is_the_best_reply()
    {
        $reply = create('App\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->isBest());
    }*/

   /* public function test_only_the_thread_creator_may_mark_a_reply_as_best()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread',['user_id' => auth()->id()]);

        $replies = create('App\Reply',['thread_id' => $thread->id],2);

        $this->signIn(create('App\User'));

        $this->postJson(route('best-replies.store',[$replies[1]->id]))
            ->assertStatus(403);

        $this->assertFalse($replies[1]->fresh()->isBest());
    }*/

    public function test_a_reply_body_is_sanitized_automatically()
    {
        $reply = create('App\Reply',['body' => "<script>alert('bad')</script><p>This is OK.</p>"]);

        $this->assertEquals("<p>This is OK.</p>",$reply->body);
    }
}
