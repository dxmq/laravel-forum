<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Reply;
use App\Thread;


class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'must-be-confirmed'], ['except' => 'index']); // 只有登录的用户才能回复
    }

    public function index(Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Thread $thread, CreatePostRequest $request)
    {
        if ($thread->locked) {
            return response('话题被锁定，不能被回复', 422);
        }

        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ])->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required|spamfree']);

        $reply->update(request(['body']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }

    public function favorite(Reply $reply)
    {
        $reply->favorite();

        return back();
    }

    public function unFavorite(Reply $reply)
    {
        $reply->unFavorite();
    }
}
