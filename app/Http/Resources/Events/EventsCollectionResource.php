<?php

namespace App\Http\Resources\Events;

use App\Trending;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class EventsCollectionResource
 * @package App\Http\Resources\Events
 */
class EventsCollectionResource extends ResourceCollection
{
    /**
     * @var Trending
     */
    protected $trending;

    /**
     * EventsCollectionResource constructor.
     * @param $resource
     * @param Trending $trending
     */
    public function __construct($resource, Trending $trending)
    {
        parent::__construct($resource);

        $this->trending = $trending;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'events' => EventResource::collection($this->collection),
                'trending' => $this->trending->get()
            ]
        ];
    }
}
