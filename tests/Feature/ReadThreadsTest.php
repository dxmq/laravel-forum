<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /*public function a_user_can_browse_threads() // 一个用户能够参与的话题
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
    }*/

    protected $thread;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = factory('App\Thread')->create();
    }

    /*
    public function test_a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_that_are_associated__with_a_thread()
    {
        // 如果存在 Thread
        // 并且该 Thread 拥有回复
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        // 那么当我们看该 Thread 时
        // 我们也要看到回复
        $this->get($this->thread->path())->assertSee($reply->only);
    }*/

  /* public function test_a_user_can_filter_threads_according_to_a_channel() // 一个用户能够根据频道过滤话题
   {
       $channel = create('App\Channel');
       $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
       $threadNotInChannel = create('App\Thread');

       $this->get('/threads/' . $channel->slug)
           ->assertSee($threadInChannel->title)
           ->assertDontSee($threadNotInChannel->title);
   }*/

 /* public function test_a_user_can_filter_threads_by_any_username()
  {
      $this->signIn(create('App\User', ['name' => 'NoNo1']));

      $threadByNoNo1 = create('App\Thread', ['user_id' => auth()->id()]);
      $threadNotByNoNo1 = create('App\Thread');

      $this->get('threads?by=NoNo1')
          ->assertSee($threadByNoNo1->title)
          ->assertDontSee($threadNotByNoNo1->title);
  }*/

    /*public function test_a_user_can_filter_threads_by_popularity()
    {
         // Given we have three threads
        // With 2 replies,3 replies,0 replies, respectively
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply',['thread_id'=>$threadWithTwoReplies->id],2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply',['thread_id'=>$threadWithThreeReplies->id],3);

        $threadWithNoReplies = $this->thread;

        // When I filter all threads by popularity
        $response = $this->getJson('threads?popularity=1')->json();

        // Then they should be returned from most replies to least.
        $this->assertEquals([3,2,0],array_column($response['data'],'replies_count'));
    }*/

    /*public function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply',['thread_id' => $thread->id],2);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(1,$response['data']);
        $this->assertEquals(2,$response['total']);
    }*/

    /*public function test_a_user_can_filter_threads_by_those_that_are_unanswered()
    {
         $thread = create('App\Thread');
        create('App\Reply',['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1,$response['data']);
    }*/

}
