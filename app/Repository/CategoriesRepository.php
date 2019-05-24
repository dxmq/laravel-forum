<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/18
 * Time: 11:03
 */

namespace App\Repository;


use App\Category;
use App\Post;

class CategoriesRepository
{
    protected $category;
    protected $post;

    public function __construct(Category $category, Post $post)
    {
        $this->category = $category;
        $this->post = $post;
    }

    public function getCategories()
    {
        return $this->category->latest()->get();
    }

    public function getPostsByCategory($category)
    {
        return $category->posts()->paginate(6);
    }
}