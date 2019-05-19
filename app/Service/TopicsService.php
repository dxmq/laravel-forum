<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/19
 * Time: 11:29
 */

namespace App\Service;


use App\Repository\TopicsRepository;

class TopicsService
{
    protected $topicsRepository;

    public function __construct(TopicsRepository $topicsRepository)
    {
        $this->topicsRepository = $topicsRepository;
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic) {
            if (is_numeric($topic)) {
                return $topic;
            }

            $newTopic = $this->topicsRepository->createTopic([ // 如果不是数字就创建
                'name' => $topic
            ]);
            return $newTopic->id;
        })->toArray();
    }
}