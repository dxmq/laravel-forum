<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Valiner\IdenticonAvatar\Identicon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
        'description',
        'avatar_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'confirmed' => 'boolean',
    ];

    public function confirm()
    {
        $this->confirmed = true;

        $this->confirmation_token = null;

        $this->save();
    }

    public function isAdmin()
    {
        return in_array($this->name, ['admin']);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);

        if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $value)) {
            $slug = str_slug(pinyin_sentence($value));
        }

        return $this->attributes['slug'] = $slug;
    }

    public function threads()
    {
        return $this->hasMany('App\Thread')->latest();
    }

    public function replies()
    {
        return $this->hasMany('App\Reply')->latest();
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

    public function getAvatarPathAttribute()
    {
        if (empty($this->attributes['avatar_path'])) {
            $filename = sprintf('avatars/%s.png', $this->id);
            $filepath = storage_path('app/public/'.$filename);
            if ( ! is_dir(dirname($filepath))) {
                mkdir(dirname($filepath), 0755, true);
            }
            $identicon = new Identicon();

            $identicon->saveAvatar($this->name, 100, $filepath);
            $this->update(['avatar_path' => sprintf('storage/%s', $filename)]);
        }

        return asset($this->attributes['avatar_path']);
    }

}
