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

    protected $events = [];

    /**
     * Filters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**     *
     * @return Request
     */
    public function apply($query)
    {
        $this->events = [];

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->events[0];
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        if ($this->request->getRequestUri() === '/event') {
            return ['all' => 'all'];
        }

        return $this->request->only($this->filters);
    }
}
