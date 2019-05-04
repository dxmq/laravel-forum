<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{

    protected $request,$builder;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     * @return mixed
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value){
            if(method_exists($this, $filter)){  // 注：此处是 hasFilter() 方法的重构
                $this->$filter($value);
            }
        }


        return $this->builder;
    }

    /**
     * @param $filter
     * @return bool
     */
    /*protected function hasFilter($filter)
    {
        return method_exists($this, $filter) && $this->request->has($filter);
    }*/

    public function getFilters()
    {
        return array_filter($this->request->only($this->filters));
    }
}