<?php

namespace App\Http\Controllers;

use App\Service\CategoriesService;
use App\Service\PostsService;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    protected $categoriesService;
    protected $postsService;

    public function __construct(CategoriesService $categoriesService, PostsService $postsService)
    {
        $this->categoriesService = $categoriesService;
        $this->postsService = $postsService;
    }

    public function create()
    {
        // 获取categories
        $categories = $this->categoriesService->getCategories();

        return view('posts.create', compact('categories'));
    }

    public function store()
    {

    }
}
