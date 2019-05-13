<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/13
 * Time: 16:38
 */

namespace App;

use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    protected function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }

    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?: 0;
    }

    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());

        return $this;
    }
}