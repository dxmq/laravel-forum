<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Searching\Interfaces\SearchingInterface;
use Searching\Prototypes\CategoryNamePrototype;
use Searching\Prototypes\ColumnsPrototype;
use Searching\Prototypes\ShortcutsPrototype;
use Searching\Prototypes\CategoryUrlPrototype;
use Searching\Prototypes\UrlPrototype;
use Spatie\Activitylog\Models\Activity;
use Valiner\IdenticonAvatar\Identicon;
use Laravelista\Comments\Commenter;

class User extends Authenticatable implements SearchingInterface
{
    use Notifiable, Commenter;

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
        'confirmed',
        'github_name',
        'provider'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'confirmation_token'
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


    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::deleting(function ($user){
            $user->posts()->delete();
            $user->threads()->delete();
            $user->replies()->delete();
            $user->comments()->delete();
            $user->activity()->delete();
        });
    }

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
        $slug = str_slug(pinyin_sentence($value));

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

    public function posts()
    {
        return $this->hasMany('App\Post')->latest();
    }

    public function getPostsCount() // 获取当前用户的文章数
    {
        return $this->posts()->count();
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

    // 我的粉丝
    public function fans()
    {
        return $this->hasMany(Fan::class, 'star_id', 'id');
    }

    public function hasFan($user_id)
    {
        return $this->fans()->where('fan_id', $user_id)->count();
    }

    // 我关注(粉)的人
    public function stars()
    {
        return $this->hasMany(Fan::class, 'fan_id', 'id');
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

    // 实现SearchingInterFace相关方法
    /**
     * 获取搜索组名
     *
     * @return CategoryNamePrototype
     */
    public static function getSearchableCategoryName() : CategoryNamePrototype
    {
        return new CategoryNamePrototype('用户');
    }
    /**
     * 获取可被搜索的字段
     *
     * @return ColumnsPrototype
     */
    public static function getSearchableColumns() : ColumnsPrototype
    {
        return new ColumnsPrototype('name', 'description');
    }
    /**
     * 获取搜索分组快捷键
     *
     * @return ShortcutsPrototype
     */
    public static function getSearchableShortcuts() : ShortcutsPrototype
    {
        return new ShortcutsPrototype('yh');
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
        return new UrlPrototype('profile', $this);
    }
}
