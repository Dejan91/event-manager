<?php


namespace App\Http\Resources\ResourceIncludes;


/**
 * Class EventResourceIncludes
 * @package App\Http\Resources\ResourceIncludes
 */
class EventResourceIncludes extends ResourceIncludes
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'creator',
        'favorites',
        'subscription',
        'country',
    ];
}
