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
        $this->middleware(['auth', 'must-be-confirmed'])->except(['show', 'index']);
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
        request()->validate([
            'category_id' => 'required',
            'title' => 'required|max:200',
            'topics' => 'required',
            'body' => 'required|min:6',
        ]);

        // 转为标准的topics
        $topics = $this->topicsService->normalizeTopic(request('topics'));

        $params = array_merge(request(['category_id', 'title', 'body']), ['user_id' => auth()->id()]);

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

    public function edit(Post $post)
    {
        $post->load('topics');

        $categories = $this->categoriesService->getCategories();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Post $post)
    {
        request()->validate([
            'category_id' => 'required',
            'title' => 'required|max:200',
            'topics' => 'required',
            'body' => 'required|min:6',
        ]);

        $this->authorize('update', $post);

        $params = request(['category_id', 'title', 'body']);

        $this->postsService->updatePost($post, $params);

        $this->topicsService->updatePostTopics($post, request('topics')); // 维护中间表

        return redirect('/')
            ->with('flash', '文章修改成功！');
    }

    public function destroy($id)
    {
        $post = new Post();

        // 策略验证
        $this->authorize('update', $post);

        $this->postsService->deletePost($id);

        return redirect("/")
            ->with('文章已经删除！');
    }
}
