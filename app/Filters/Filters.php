<?php

namespace App\Filters;

use Illuminate\Http\Request;

/**
 * Class Filters
 * @package App\Filters
 */
abstract class Filters
{
    /**
     * @var Request
     */
    /**
     * @var Request
     */
    protected $request, $builder;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * Filters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $builder
     *
     * @return Request
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
