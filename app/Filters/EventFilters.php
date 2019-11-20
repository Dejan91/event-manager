<?php

namespace App\Filters;

use Carbon\Carbon;

class EventFilters extends Filters
{
    protected $filters = ['commented', 'start', 'end'];

    public function commented()
    {
        $this->builder->getQuery()->orders = [];

        $this->builder->orderBy('comments_count', 'desc');
    }

    public function start($date)
    {
        $date = Carbon::parse($date)->format('Y-m-d');
        
        $this->builder->where('start_date', '>=', $date);
    }

    public function end($date)
    {
        $date = Carbon::parse($date)->format('Y-m-d');

        $this->builder->where('end_date', '<=', $date);
    }
}