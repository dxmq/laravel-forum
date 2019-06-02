<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/6
 * Time: 12:54
 */

namespace App\Traits;

use App\Favorite;
/**
 * 点赞相关
 * Class Favoritable
 * @package App
 */
trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $this->favorites()->where($attributes)->exists()) { // 用户不能重复点赞
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited()
    {
        return ! ! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function unFavorite()
    {
        $attribute = ['user_id' => auth()->id()];

        $this->favorites()->where($attribute)->get()->each->delete();
    }
}