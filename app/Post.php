<?php

namespace App;

use App\Traits\Favoritable;
use Laravelista\Comments\Comment;
use Searching\Interfaces\SearchingInterface;
use Searching\Prototypes\CategoryNamePrototype;
use Searching\Prototypes\ColumnsPrototype;
use Searching\Prototypes\ShortcutsPrototype;
use Searching\Prototypes\CategoryUrlPrototype;
use Searching\Prototypes\UrlPrototype;
use Laravelista\Comments\Commentable;

class Post extends Model implements SearchingInterface
{
    use Commentable, Favoritable;

    protected $with = ['favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $post->update([
                'slug' => $post->title,
            ]);
        });

        static::deleting(function ($post) { // 删除文章时同时删除
            $post->comments()->delete();
            $post->favorites()->delete();
            $post->activities()->delete();
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


    /**
     * 获取搜索组名
     *
     * @return CategoryNamePrototype
     */
    public static function getSearchableCategoryName(): CategoryNamePrototype
    {
        return new CategoryNamePrototype('文章');
    }

    /**
     * 获取可被搜索的字段
     *
     * @return ColumnsPrototype
     */
    public static function getSearchableColumns(): ColumnsPrototype
    {
        return new ColumnsPrototype('title', 'body');
    }

    /**
     * 获取搜索分组快捷键
     *
     * @return ShortcutsPrototype
     */
    public static function getSearchableShortcuts(): ShortcutsPrototype
    {
        return new ShortcutsPrototype('wz');
    }

    /**
     * 模型列表路由
     *
     * @return CategoryUrlPrototype
     */
    public static function getSearchableCategoryUrl(): CategoryUrlPrototype
    {
        return new CategoryUrlPrototype('posts.index');
    }

    /**
     * 模型详情路由
     *
     * @return UrlPrototype
     */
    public function getSearchableUrl(): UrlPrototype
    {
        return new UrlPrototype('posts.show', $this);
    }
}
