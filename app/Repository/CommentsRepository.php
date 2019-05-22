<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/21
 * Time: 20:21
 */

namespace App\Repository;


use App\Comment;

class CommentsRepository
{
    public function findCommentByParentId($parentId)
    {
        return Comment::findOrFail($parentId);
    }
}