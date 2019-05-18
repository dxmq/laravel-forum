<?php

namespace App;

use App\Traits\RecordsActivity;

class Favorite extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function favorited()
    {
        return $this->morphTo();
    }
}
