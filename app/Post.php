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
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'post_topics', 'post_id', 'topic_id')->withTimestamps();
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
}
