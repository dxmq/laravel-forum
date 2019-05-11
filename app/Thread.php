<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator', 'channel'];
    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete(); // 删除回复
        });

    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
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

        event(new ThreadHasNewReply($this, $reply)); // 用事件方式通知

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
}
