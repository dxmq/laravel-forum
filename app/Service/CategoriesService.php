<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/18
 * Time: 11:02
 */

namespace App\Service;


use App\Repository\CategoriesRepository;
use Illuminate\Support\Facades\Cache;

class CategoriesService
{
    protected $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function getCategories()
    {
        $categories = Cache::get('categories');

        if ( ! $categories) {
            $categories = $this->categoriesRepository->getCategories();
            Cache::put('categories', $categories, 60);
        }

        return $categories;
    }

    public function getPostsByCategory($category)
    {
        return $this->categoriesRepository->getPostsByCategory($category);
    }
}