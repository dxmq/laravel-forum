<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   /* public function test_a_authenticated_can_create_new_forum_threads()
    {
        // Given we have a signed in user
//        $this->actingAs(factory('App\User')->create());

        $this->signIn(create('App\User'));

        // When we hit the endpoint to create a new thread
//        $thread = factory('App\Thread')->make();
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());

        // Then,when we visit the thread
        // We should see the new thread
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }*/

    /*public function test_a_guest_may_not_create_threads()
    {
        $this->withExceptionHandling(); // 在此处抛出异常即代表测试通过

        $this->get('/threads/create')->assertRedirect('/login');

        $this->post('/threads')->assertRedirect('/login');

    }*/

    /*public function test_guests_may_not_bee_the_create_thread_page()
    {
        $this->withExceptionHandling()->get('/threads/create')->assertRedirect('/login');
    }*/

    /*public function test_a_thread_requires_a_title()
    {

        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread',$overrides);

        return $this->post('/threads',$thread->toArray());
    }

    public function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }



    public function test_a_thread_requires_a_valid_channel() // 测试channel_id是否存在
    {
        factory('App\Channel',2)->create(); // 新建两个 Channel，id 分别为 1 跟 2

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])  // channle_id 为 999，是一个不存在的 Channel
        ->assertSessionHasErrors('channel_id');
    }*/

    /*public function authorized_users_can_delete_threads()
{
    $this->signIn();

    $thread = create('App\Thread',['user_id' => auth()->id()]);
    $reply = create('App\Reply',['thread_id' => $thread->id]);

    $response =  $this->json('DELETE',$thread->path());

    $response->assertStatus(204);

    $this->assertDatabaseMissing('threads',['id' => $thread->id]);
    $this->assertDatabaseMissing('replies',['id' => $reply->id]);
}
*/

  /*  public function test_guests_cannot_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');
    }*/

    /*public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }*/

}
