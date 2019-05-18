<?php

namespace App;

class Channel extends Model
{
    public function threads()
    {
        return $this->hasMany('App\Thread');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
