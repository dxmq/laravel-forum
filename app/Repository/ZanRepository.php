<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/22
 * Time: 19:23
 */

namespace App\Repository;


use App\Zan;

class ZanRepository
{
    protected $zan;

    public function __construct(Zan $zan)
    {
        $this->zan = $zan;
    }

    public function createZan($zan_post)
    {
        $this->zan->user_id = auth()->id();
        $zan_post->zans()->save($this->zan);
    }

    public function deleteZan($zan_post)
    {
        $zan = Zan::where(['post_id' => $zan_post->id, 'user_id' => auth()->id()]);

        $zan_post->zans()->delete($zan);
    }
}