<?php

namespace App;

class Post extends Model
{
    protected $fillable = [
        'title', 'body', 'user_id', 'category_id'
    ];

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'post_topics', 'post_id', 'topic_id')->withTimestamps();
    }
}
