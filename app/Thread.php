<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

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
    public function replies():HasMany
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
        $this->replies()->create($reply);
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
}
