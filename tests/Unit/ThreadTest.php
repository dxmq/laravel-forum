<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Notifications\ThreadWasUpdated;

class ThreadTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = factory('App\Thread')->create();
    }

    /*
    public function test_a_user_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_a_thread_has_a_creator() // 话题的创建者
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }*/

   /* public function test_a_thread_can_add_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }*/

   /*public function test_a_thread_belongs_to_a_channel() // 测试一个话题属于一个频道
   {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
   }*/

/*   public function test_a_thread_can_make_a_string_path() // 我们期望访问 http://forum.test/threads/1 时实际是访问并且显示 http://forum.test/threads/{channel}/1
   {
       $thread = create('App\Thread');

       $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
   }*/

    /*public function test_a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $thread->subscribe();

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', auth()->id())->count());
    }*/

    /*public function test_a_thread_can_be_unsubscribed_from()
    {
        // Given we have a thread
        $thread = create('App\Thread');

        // And a user who is subscribed to the thread
        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0,$thread->subscriptions);
    }*/

    /*public function test_it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        // Given we have a thread
        $thread = create('App\Thread');

        // And a user who is subscribed to the thread
        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }*/

   /* public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'body' => 'Foobar',
                'user_id' => 999
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }*/

    public function test_a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        tap(auth()->user(),function ($user) use ($thread){
            $this->assertTrue($thread->hasUpdatesFor($user));

            $user->read($thread);

            $this->assertFalse($thread->hasUpdatesFor($user));
        });
    }
}
