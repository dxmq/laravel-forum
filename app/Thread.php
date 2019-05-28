<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\RecordsActivity;
use Searching\Interfaces\SearchingInterface;
use Searching\Prototypes\CategoryNamePrototype;
use Searching\Prototypes\ColumnsPrototype;
use Searching\Prototypes\ShortcutsPrototype;
use Searching\Prototypes\CategoryUrlPrototype;
use Searching\Prototypes\UrlPrototype;

class Thread extends Model implements SearchingInterface
{
    use RecordsActivity;

    protected $with = ['creator', 'channel'];
    protected $appends = ['isSubscribedTo'];
    protected $casts = [
        'locked' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

        static::created(function ($thread) {
            $thread->update([
                'slug' => $thread->title,
                'body' => clean($thread->body, 'thread_or_reply_body')
            ]);
        });

    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
       $this->setSlug($value);
    }

    protected function incrementSlug($slug)
    {
        // 取出最大 id 话题的 Slug 值
        $max = static::whereTitle($this->title)->latest('id')->value('slug');

        // 如果最后一个字符为数字
        if (is_numeric($max[-1])) {
            // 正则匹配出末尾的数字，然后自增 1
            return preg_replace_callback('/(\d+)$/', function ($matches) {
                return $matches[1] + 1;
            }, $max);
        }

        // 否则后缀数字为 2
        return "{$slug}-2";
    }

    public function path()
    {
        return "/threads/{$this->slug}";
    }


    /**
     * 当前话题下有许多的回复
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 许多个话题属于这个用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 添加回复
     * @param $reply
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadHasNewReply($this, $reply)); // 话题订阅通知

        event(new ThreadReceivedNewReply($reply)); // @某人

        return $reply;
    }

    /**
     * 这个话题所属的频道
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    // 过滤threads
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }


    /**
     * 订阅动作
     * @param null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    /**
     * 话题订阅
     * @return HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this); // 获取用户浏览该话题的key

        return $this->updated_at > cache($key);
    }


    /**
     * 标记最佳回复
     * @param $reply
     */
    public function markBestReply($reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }


    // 实现SearchingInterFace相关方法
    /**
     * 获取搜索组名
     *
     * @return CategoryNamePrototype
     */
    public static function getSearchableCategoryName() : CategoryNamePrototype
    {
        return new CategoryNamePrototype('话题');
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
        return new ShortcutsPrototype('ht');
    }
    /**
     * 模型列表路由
     *
     * @return CategoryUrlPrototype
     */
    public static function getSearchableCategoryUrl() : CategoryUrlPrototype
    {
        return new CategoryUrlPrototype('threads');
    }
    /**
     * 模型详情路由
     *
     * @return UrlPrototype
     */
    public function getSearchableUrl() : UrlPrototype
    {
        return new UrlPrototype('threads.show', $this);
    }
}
