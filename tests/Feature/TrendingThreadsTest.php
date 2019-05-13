<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Trending;

class TrendingThreadsTest extends TestCase
{
    public function setUpTraits()
    {
        parent::setUpTraits();

        $this->trending = new Trending();

        $this->trending->reset();
    }

    /** @test */
    public function it_increments_a_thread_score_each_time_it_is_read()
    {
        $this->assertEmpty($this->trending->get());

        $thread = create('App\Thread');

        $this->call('GET',$thread->path());

        $this->assertCount(1,$trending = $this->trending->get());

        $this->assertEquals($thread->title,$trending[0]->title);
    }
}
