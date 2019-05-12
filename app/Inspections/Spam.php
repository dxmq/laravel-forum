<?php


namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class, // 检查关键字
        KeyHeldDown::class, // 检查是否重复
    ];

    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}