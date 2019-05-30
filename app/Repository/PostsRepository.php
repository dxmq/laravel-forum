<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/18
 * Time: 10:56
 */

namespace App\Repository;


use App\Post;

class PostsRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function createPost($params)
    {
        return $this->post->create($params);
    }

    public function getPosts()
    {
        return $this->post->with(['topics', 'creator', 'category', 'zans', 'comments'])->latest()->paginate(6);
    }

    public function update($post, $params)
    {
        return $post->update($params);
    }

    public function delete($id)
    {
        $post = $this->post->findOrFail($id);

        $post->delete();
    }

    public function getPreviousPost($id)
    {
        $previousId = $this->post->where('id', '<', $id)->max('id');

        return $this->post->select(['title', 'slug'])->find($previousId);
    }

    public function getNextPost($id)
    {
        $nextId = $this->post->where('id', '>', $id)->min('id');

        return $this->post->select(['title', 'slug'])->find($nextId);
    }
}