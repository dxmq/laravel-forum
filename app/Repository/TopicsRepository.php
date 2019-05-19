<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/18
 * Time: 11:42
 */

namespace App\Repository;

use App\Topic;

class TopicsRepository
{
    protected $topic;

    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function getTopics($query)
    {
        return $this->topic->where('name', 'like', '%' . $query . '%')->get();
    }

    public function createTopic($topics)
    {
        return $this->topic->create($topics);
    }
}