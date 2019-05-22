<?php

namespace App;

class Comment extends Model
{
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    // 这个评论的子评论
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
