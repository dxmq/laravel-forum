<?php

namespace App;

class Topic extends Model
{
    public function posts()
    {
        return $this->belongsToMany('App\Post', 'post_topics', 'post_id', 'topic_id');
    }
}
