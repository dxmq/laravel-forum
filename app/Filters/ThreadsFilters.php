<?php

namespace App\Filters;

use App\User;

class ThreadsFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered'];

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
}