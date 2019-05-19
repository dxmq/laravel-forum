<?php

namespace App\Http\Controllers;

use App\Service\CategoriesService;
use App\Service\PostsService;
use App\Service\TopicsService;
use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    protected $categoriesService;
    protected $postsService;
    protected $topicsService;

    public function __construct(
        CategoriesService $categoriesService,
        PostsService $postsService,
        TopicsService $topicsService
    ) {
        $this->middleware(['auth'])->except(['show', 'index']);
        $this->categoriesService = $categoriesService;
        $this->postsService = $postsService;
        $this->topicsService = $topicsService;
    }

    public function create()
    {
        $categories = $this->categoriesService->getCategories();

        return view('posts.create', compact('categories'));
    }

    public function store()
    {
        $postData = request()->validate([
            'category_id' => 'required',
            'title' => 'required|max:200',
            'body' => 'required|min:6'
        ]);

        // 转为标准的topics
        $topics = $this->topicsService->normalizeTopic(request('topics'));

        $params = array_merge($postData, ['user_id' => auth()->id()]);

        $post = $this->postsService->createPost($params);

        // 添加关联
        $post->topics()->attach($topics);

        return redirect("/")
            ->with('flash', '你的文章已经创建！');
    }

    public function show(Post $post)
    {
        $post->load('creator');

        $parseDown = new \Parsedown();
        $post->body = $parseDown->text($post->body);

        visits($post)->increment(); // 增加访问量

        return view('posts.show', compact('post'));
    }
}
