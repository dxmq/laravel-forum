<?php

namespace App\Http\Controllers;

use App\Category;
use App\Service\CategoriesService;
use App\Service\PostsService;
use App\Service\TopicsService;
use App\Topic;
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
        $this->middleware(['auth', 'must-be-confirmed'])->except(['show', 'index', 'category', 'topic']);
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
            'topics' => 'array',
            'body' => 'required|min:6',
        ]);

        // 转为标准的topics
        $topics = request('topics');

        $params = array_merge(request(['category_id', 'title', 'body']), ['user_id' => auth()->id()]);

        $post = $this->postsService->createPost($params);

        // 添加关联
        $post->topics()->attach($topics);

        activity('posts')->performedOn($post)
            ->log('创建了文章');

        return redirect("/")
            ->with('flash', '你的文章已经创建！');
    }

    public function show(Post $post)
    {
        $post->load('creator');
        $post->load('comments');

        $parseDown = new \Parsedown(); // 解析markdown
        $post->body = $parseDown->text($post->body);

        visits($post)->increment(); // 增加访问量

        $previousPost = $this->postsService->getPreviousPost($post->id); // 获取上一篇和下一篇
        $nextPost = $this->postsService->getNextPost($post->id);

        return view('posts.show', compact('post', 'previousPost', 'nextPost'));
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

        $params['slug'] = request('title');

        $this->postsService->updatePost($post, $params);

        $this->topicsService->updatePostTopics($post, request('topics')); // 维护中间表

        return redirect('/')
            ->with('flash', '文章修改成功！');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // 策略验证
        $this->authorize('update', $post);

        $this->postsService->deletePost($id);

        return redirect("/")
            ->with('文章已经删除！');
    }

    public function zan($id)
    {
        $post = Post::findOrFail($id);
        $post->favorite();

        return back();
    }

    public function unzan($id)
    {
        $post = Post::findOrFail($id);
        $post->unFavorite();
    }


    public function category(Category $category)
    {
        $posts = $this->categoriesService->getPostsByCategory($category);

        $category = $category->name;

        return view('posts.index', compact('posts', 'category'));
    }

    public function topic(Topic $topic)
    {
        $posts = $this->topicsService->getPostsByTopic($topic);

        $topic = $topic->name;

        return view('posts.index', compact('posts', 'topic'));
    }

}
