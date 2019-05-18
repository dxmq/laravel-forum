<?php

namespace App;

class Post extends Model
{
    protected $fillable = [
        'title', 'body', 'user_id', 'category_id'
    ];
}
