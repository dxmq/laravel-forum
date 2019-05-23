<?php

namespace App;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'body',
        'user_id',
        'category_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $post->update([
                'slug' => $post->title,
            ]);
        });

        static::updated(function ($post) {
            $post->update([
                'slug' => $post->title
            ]);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'post_topics', 'post_id', 'topic_id')->withTimestamps();
    }

    public function deleteTopics($topics) // 删除与topic的关联
    {
        $this->topics()->detach($topics);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function setSlugAttribute($value)
    {
        $this->setSlug($value);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 获取这篇文章的评论并以parent_id分组
    public function getComments()
    {
        return $this->comments()->with('owner')->get()->groupBy('parent_id');
    }

    // 此文章所有赞
    public function zans()
    {
        return $this->hasMany(Zan::class, 'post_id', 'id');
    }

    public function isZan() // 判断一个用户是否点赞过
    {
        return !!$this->zans()->where('user_id', auth()->id())->count();
    }

}
