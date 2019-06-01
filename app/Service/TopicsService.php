<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/19
 * Time: 11:29
 */

namespace App\Service;


use App\Post;
use App\Repository\TopicsRepository;

class TopicsService
{
    protected $topicsRepository;

    public function __construct(TopicsRepository $topicsRepository)
    {
        $this->topicsRepository = $topicsRepository;
    }

    public function updatePostTopics(Post $post, $topics)
    {
        $this->topicsRepository->updatePostTopics($post, $topics);
    }

    public function getPostsByTopic($topic)
    {
        return $this->topicsRepository->getPostsByTopic($topic);
    }
}