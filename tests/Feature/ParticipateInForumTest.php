<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    /**
     * A basic feature test example.
     * 一个被授权过的用户可能参与到论坛话题中
     * @return void
     */
    /*public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have a authenticated user
        $this->be($user = factory('App\User')->create());
        // And an existing thread
        $thread = factory('App\Thread')->create();
        // When the user adds a reply to the thread
        $reply = factory('App\Reply')->create();
        $this->post($thread->path().'/replies', $reply->toArray());
        // Then their reply should be visible on the page
        $this->get($thread->path())->assertSee($reply->body);
    }*/

 /*   public function test_unauthenticated_may_no_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
//        $this->post('threads/1/replies', []);
    }*/

    public function test_a_reply_requires_a_body() // 测试一个回复的内容必填
    {
        $this->withExceptionHandling()->signIn(); // 需要登录

        $thread = create('App\Thread');

        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path(). '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}

