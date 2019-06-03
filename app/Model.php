<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/18
 * Time: 10:31
 */

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Spatie\Activitylog\Models\Activity;

class Model extends EloquentModel
{
    protected $guarded = [];

    public function setSlug($value)
    {
        $slug = str_slug(pinyin_sentence($value));

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }

        return $this->attributes['slug'] = $slug;
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}