<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/21
 * Time: 20:18
 */

namespace App\Service;


use App\Repository\CommentsRepository;

class CommentsService
{
    protected $commentsRepository;

    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    public function findCommentByParentId($parentId)
    {
        return $this->commentsRepository->findCommentByParentId($parentId);
    }

    public function createComment($post, $params)
    {
        return $post->comments()->create($params);
    }
}