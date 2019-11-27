<?php

namespace App\Filters;

use App\Country;
use Carbon\Carbon;

class EventFilters extends Filters
{
    protected $filters = ['commented', 'start', 'end', 'title', 'description', 'country'];

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
        if ($date) {
            $date = Carbon::parse($date)->format('Y-m-d');

            $this->builder->where('end_date', '<=', $date);
        } else {
            $this->builder->where('end_date', '<=', Carbon::now()->addYear());
        }
    }

    public function title($title)
    {
        $this->builder->where('title', 'LIKE', "%{$title}%");
    }

    public function description($description)
    {
        $searchValues = preg_split('/\s+/', $description, -1, PREG_SPLIT_NO_EMPTY);

        $this->builder->where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
                $q->orWhere('description', 'like', "%{$value}%");
            }
        });
    }

    public function country($country)
    {
        $countries = Country::where('name', 'LIKE', "%{$country}%")->get()->map(function ($country) {
            return $country->id;
        });

        $this->builder->whereIn('country_id', $countries);
    }
}
