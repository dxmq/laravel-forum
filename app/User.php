<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'confirmed' => 'boolean'
    ];

    public function confirm()
    {
        $this->confirmed = true;

        $this->confirmation_token = null;

        $this->save();
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads()
    {
        return $this->hasMany('App\Thread')->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * 用户浏览话题的动作
     * @param $thread
     * @throws \Exception
     */
    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            \Carbon\Carbon::now()
        );
    }

    public function visitedThreadCacheKey($thread)
    {
        return $key = sprintf("users.%s.visits.%s", $this->id, $thread);
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function avatar()
    {
        return $this->avatar_path ?: 'avatars/default.png';
    }

    public function getAvatarPathAttribute($avatar)
    {
        return $avatar ?: 'avatars/default.png';
    }
}
