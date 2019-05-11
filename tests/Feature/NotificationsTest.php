<?php

namespace Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user(
    )
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some reply here',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function test_a_user_can_fetch_their_unread_notifications()
    {
        $this->signIn();

        create(DatabaseNotification::class);
        $user = auth()->user();

        $response = $this->getJson('/profiles/'.$user->name.'/notifications')->json();

        $this->assertCount(1, $response);
    }

    public function test_a_user_can_clear_a_notification()
    {
        $this->signIn();

        create(DatabaseNotification::class);

        tap(auth()->user(), function ($user) {
            $this->assertCount(1, $user->unreadNotifications);

            $this->delete("/profiles/".$user->name."/notifications/".$user->unreadNotifications->first()->id);

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }
}