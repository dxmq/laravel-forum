<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/18
 * Time: 10:31
 */

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $guarded = [];

    public function setSlug($value)
    {
        $slug = str_slug($value);

        if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $value)) {
            $slug = str_slug(pinyin_sentence($value));
        }

        if (static::where('slug', $slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }

        return $this->attributes['slug'] = $slug;
    }
}