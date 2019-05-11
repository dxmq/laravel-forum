<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /*public function test_a_user_can_unsubscribe_from_threads()
    {
         $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0,$thread->subscriptions);
    }*/
}
