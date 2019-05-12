<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
   public function test_it_validates_spam()
   {
       $spam = new Spam();

       $this->assertFalse($spam->detect('Innocent reply here.'));

       $this->expectException('Exception');

       $spam->detect('something forbidden');
   }

    public function test_it_checks_for_any_being_held_down()
    {
        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect('Hello word aaaaaaaaaa');
    }
}
