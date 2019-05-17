<?php

namespace App\Filters;

use App\Trending;
use App\User;

class ThreadsFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered', 'recently'];

    /**
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrfail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * @return mixed
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count','desc');
    }

    /**
     * @return mixed
     */
    public function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }

    public function recently()
    {
        return $this->builder;
    }
}