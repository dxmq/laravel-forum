<?php

namespace App\Http\Controllers;

use App\Service\PostsService;
use Illuminate\Http\Request;
use Laravelista\Ekko\Ekko;

class IndexController extends Controller
{
    protected $postsService;

    public function __construct(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    public function index()
    {
        // 获取posts
        $posts = $this->postsService->getPosts();

        return view('posts.index', compact('posts'));
    }
}
