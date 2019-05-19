<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/18
 * Time: 10:55
 */

namespace App\Service;


use App\Repository\PostsRepository;

class PostsService
{
    protected $postsRepository;

    public function __construct(PostsRepository $postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function createPost($params)
    {
        return $this->postsRepository->createPost($params);
    }

    public function getPosts()
    {
        return $this->postsRepository->getPosts();
    }
}