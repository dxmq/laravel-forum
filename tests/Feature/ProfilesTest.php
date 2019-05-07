<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   /*public function test_a_user_has_a_profile()
   {
       $user = create('App\User');

       $this->get("/profiles/{$user->name}")
           ->assertSee($user->name);
   }*/

   public function test_profiles_display_all_threads_created_by_the_associated_user()
   {
       $this->signIn();

       $thread = create('App\Thread', ['user_id' => $user->id]);

       $this->get("/profiles/{$user->name}")
           ->assertSee($thread->title)
           ->assertSee($thread->body);
   }
}
