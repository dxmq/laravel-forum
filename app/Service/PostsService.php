<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/18
 * Time: 10:55
 */

namespace App\Service;


use App\Repository\PostsRepository;
use App\Repository\ZanRepository;

class PostsService
{
    protected $postsRepository;
    protected $zanRepository;

    public function __construct(PostsRepository $postsRepository, ZanRepository $zanRepository)
    {
        $this->postsRepository = $postsRepository;
        $this->zanRepository = $zanRepository;
    }

    public function createPost($params)
    {
        return $this->postsRepository->createPost($params);
    }

    public function getPosts()
    {
        return $this->postsRepository->getPosts();
    }

    public function updatePost($post, $params)
    {
        return $this->postsRepository->update($post, $params);
    }

    public function deletePost($id)
    {
        $this->postsRepository->delete($id);
    }

    public function doZan($zan_post) // 点赞
    {
        $this->zanRepository->createZan($zan_post);
    }

    public function doUnZan($zan_post) // 取消赞
    {
        $this->zanRepository->deleteZan($zan_post);
    }
}