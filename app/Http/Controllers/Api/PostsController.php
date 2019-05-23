<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Service\CommentsService;
use App\Service\PostsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    protected $commentsService;
    protected $postsService;

    public function __construct(CommentsService $commentsService, PostsService $postsService)
    {
        $this->commentsService = $commentsService;
        $this->postsService = $postsService;
    }

    public function comment($id)
    {
        $this->validate(request(), [
            'body' => 'required|spamfree',
        ]);

        if (request('parent_id')) {
            $parComment = $this->commentsService->findCommentByParentId(request('parent_id')); // 获取父评论
            $level = $parComment->level+1;

            if ($level >= 3) {
                $level = 3;
            }
        } else {
            $level = 0;
        }

        $params = array_merge(request(['parent_id', 'body']), ['level' => $level, 'user_id' => auth()->id()]);

        $post = Post::findOrfail($id);
        $comment = $this->commentsService->createComment($post, $params);
        $comment = $comment->load('owner'); // 加载关系

        return response()->json([
            'reply_block' => $comment
        ]);
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
