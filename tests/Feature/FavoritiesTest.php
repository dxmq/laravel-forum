<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritiesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   /* public function test_a_authenticate_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        // If I post a "favorite" endpoint
        $this->post('replies/' . $reply->id . '/favorites');

        // It Should be recorded in the database
        $this->assertCount(1, $reply->favorites);
    }*/

   /* public function test_guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');
    }*/

   public function test_an_authenticated_user_may_only_favorite_a_reply_once()
   {
       $this->signIn();

       $reply = create('App\Reply');

       try{
           $this->post('replies/' . $reply->id . '/favorites');
           $this->post('replies/' . $reply->id . '/favorites');
       }catch (\Exception $e){
           $this->fail('Did not expect to insert the same record set twice.');
       }

       $this->assertCount(1,$reply->favorites);
   }
}
