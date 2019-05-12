<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 2019/5/11
 * Time: 15:09
 */

namespace App\Inspections;


class KeyHeldDown
{
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('Your reply contains spam.');
        }
    }
}