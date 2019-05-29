<?php

namespace App;

class Fan extends Model
{
    public function fuser() // 粉丝用户
    {
        return $this->hasOne(User::class, 'id', 'fan_id');
    }

    public function suser() // 关注用户
    {
        return $this->hasOne(User::class, 'id', 'star_id');
    }
}
