<?php

namespace App;

use App\Traits\RecordsActivity;
use Searching\Interfaces\SearchingInterface;
use Searching\Prototypes\CategoryNamePrototype;
use Searching\Prototypes\ColumnsPrototype;
use Searching\Prototypes\ShortcutsPrototype;
use Searching\Prototypes\CategoryUrlPrototype;
use Searching\Prototypes\UrlPrototype;


class Post extends Model implements SearchingInterface
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $post->update([
                'slug' => $post->title,
            ]);

            Activity::create([ // 活动记录
                'user_id' => auth()->id(),
                'type' => 'created_post',
                'subject_id' => $post->id,
                'subject_type' => 'App\Post'
            ]);
        });

        static::deleting(function ($post) {
            $post->activity()->delete();
        });
    }

    protected function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
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

    /**
     * 获取搜索组名
     *
     * @return CategoryNamePrototype
     */
    public static function getSearchableCategoryName() : CategoryNamePrototype
    {
        return new CategoryNamePrototype('文章');
    }
    /**
     * 获取可被搜索的字段
     *
     * @return ColumnsPrototype
     */
    public static function getSearchableColumns() : ColumnsPrototype
    {
        return new ColumnsPrototype('title', 'body');
    }
    /**
     * 获取搜索分组快捷键
     *
     * @return ShortcutsPrototype
     */
    public static function getSearchableShortcuts() : ShortcutsPrototype
    {
        return new ShortcutsPrototype('wz');
    }
    /**
     * 模型列表路由
     *
     * @return CategoryUrlPrototype
     */
    public static function getSearchableCategoryUrl() : CategoryUrlPrototype
    {
        return new CategoryUrlPrototype('posts.index');
    }
    /**
     * 模型详情路由
     *
     * @return UrlPrototype
     */
    public function getSearchableUrl() : UrlPrototype
    {
        return new UrlPrototype('posts.show', $this);
    }
}
