<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];
    
    public function path()
    {
        return '/threads/' . $this->id;
    }


    /**
     * 当前话题下有许多的回复
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
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
}
