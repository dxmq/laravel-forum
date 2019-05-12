<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*public function test_mentioned_users_in_a_reply_are_notified()
    {
        $john = create('App\User',['name' => 'John']);

        $this->signIn($john);

        $jane = create('App\User',['name' => 'Jane']);

        $thread = create('App\Thread');

        $reply = make('App\Reply',[
            'body' => '@Jane look at this. And also @Luke'
        ]);

        $this->json('post',$thread->path() . '/replies',$reply->toArray());

        $this->assertCount(1,$jane->notifications);
    }

    public function test_it_can_fetch_all_users_starting_with_the_given_characters()
    {
        create('App\User',['name' => 'johndoe']);
        create('App\User',['name' => 'johndoe2']);
        create('App\User',['name' => 'janedoe']);

        $results = $this->json('GET','/api/users',['name' => 'john']);

        $this->assertCount(2,$results->json());
    }*/
}
