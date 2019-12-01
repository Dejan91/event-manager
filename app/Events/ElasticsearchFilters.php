<?php

namespace App\Events;

use Illuminate\Http\Request;

/**
 * Class Filters
 * @package App\Filters
 */
abstract class ElasticsearchFilters
{
    /**
     * @var Request
     */
    protected $request;

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
    public function apply()
    {
        $items = [];

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $items[] = $this->$filter($value);
            }
        }

        return $items;
    }
    
    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}