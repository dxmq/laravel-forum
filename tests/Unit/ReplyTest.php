<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_user_has_an_owner()
    {
        $reply = factory('App\Reply')->create(); // 创建回复

        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
