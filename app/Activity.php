<?php

namespace App;

class Activity extends Model
{
    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed($user, $take = 50)
    {
        return $user->activity()
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
