<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Service\CommentsService;
use App\Service\PostsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    protected $postsService;

    public function __construct(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    public function isZan($id)
    {
        $zan_post = Post::findOrfail($id);

        return response()->json([
            'is_zan' => $zan_post->isZan(),
            'fav_count' => $zan_post->zans()->count()
        ]);
    }

    public function zanOrCancel($id)
    {
        $zan_post = Post::findOrfail($id);

        $zan_post->isZan() ? $this->postsService->doUnZan($zan_post) : $this->postsService->doZan($zan_post);

        return response()->json([
            'is_zan' => $zan_post->isZan(),
            'fav_count' => $zan_post->zans()->count()
        ]);
    }
}
