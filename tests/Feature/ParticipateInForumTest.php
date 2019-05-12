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
        //$this->get($thread->path())->assertSee($reply->body);
     $this->assertDatabaseHas('replies',['body' => $reply->body]);
        $this->assertEquals(1,$thread->fresh()->replies_count);
    }*/

    /*   public function test_unauthenticated_may_no_add_replies()
       {
           $this->withExceptionHandling()
               ->post('/threads/some-channel/1/replies', [])
               ->assertRedirect('/login');
   //        $this->post('threads/1/replies', []);
       }*/

    /* public function test_a_reply_requires_a_body() // 测试一个回复的内容必填
     {
         $this->withExceptionHandling()->signIn(); // 需要登录

         $thread = create('App\Thread');

         $reply = make('App\Reply', ['body' => null]);

         $this->post($thread->path(). '/replies', $reply->toArray())
             ->assertSessionHasErrors('body');
     }*/

    /*public function test_unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
    }*/

    /*public function test_unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }*/

    /*public function test_authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies',['id' => $reply->id]);
        $this->assertEquals(0,$reply->thread->fresh()->replies_count);
    }*/

    /*public function test_unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->patch("replies/{$reply->id}")
            ->assertStatus(403);
    }*/

    /* public function test_authorized_user_can_update_replies()
     {
         $this->signIn();

         $reply = create('App\Reply', ['user_id' => auth()->id()]);

         $updateReply = 'You have been changed,foo.';
         $this->patch("replies/{$reply->id}", ['body' => $updateReply]);

         $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updateReply]);
     }*/

    /*public function test_replies_contains_spam_may_not_be_created()
    {
        $ $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply',[
           'body' => 'something forbidden'
        ]);

        $this->json('post',$thread->path() . '/replies',$reply->toArray())
            ->assertStatus(422);
    }*/

    /*public function test_users_may_only_reply_a_maximum_of_once_per_minute()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'My simple reply.',
        ]);

        $this->post($thread->path().'/replies', $reply->toArray())
            ->assertStatus(200);

        $this->post($thread->path().'/replies', $reply->toArray())
            ->assertStatus(429);
    }*/
}

