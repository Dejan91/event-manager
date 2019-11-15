<?php

namespace App\Filters;

class EventFilters extends Filters
{
    protected $filters = ['popular'];

    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        $this->builder->orderBy('comments_count', 'desc');
    }
}