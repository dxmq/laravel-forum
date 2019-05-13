<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*public function test_once_locked_thread_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }*/

    /*public function test_non_administrator_may_not_lock_threads()
    {
        // 开启
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread',[
            'user_id' => auth()->id()
        ]);

        // 更改
        $this->post(route('locked-threads.store',$thread))->assertStatus(403);

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    public function test_administrator_can_lock_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread',['user_id' => auth()->id()]);

        // 更改
        $this->post(route('locked-threads.store',$thread));

        $this->assertTrue(!! $thread->fresh()->locked);
    }*/

    public function test_administrator_can_unlock_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread',['user_id' => auth()->id(),'locked' => true]);

        $this->delete(route('locked-threads.destroy',$thread));

        $this->assertFalse($thread->fresh()->locked);
    }
}
