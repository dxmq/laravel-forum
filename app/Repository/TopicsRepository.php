<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/18
 * Time: 11:42
 */

namespace App\Repository;

use App\Post;
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

    public function updatePostTopics(Post $post, $topics)
    {
        $topics = $this->topic->find($topics);
        $myTopics = $post->topics;

        // 对已经有的专题
        $addTopics = $topics->diff($myTopics);
        foreach ($addTopics as $topic) {
            $post->topics()->save($topic);
        }

        $deleteTopics = $myTopics->diff($topics);
        foreach ($deleteTopics as $topic) {
            $post->deleteTopics($topic);
        }
    }

    public function getPostsByTopic($topic)
    {
        return $topic->posts()->paginate(6);
    }
}