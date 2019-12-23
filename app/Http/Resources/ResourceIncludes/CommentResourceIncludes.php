<?php


namespace App\Http\Resources\ResourceIncludes;


/**
 * Class CommentResourceIncludes
 * @package App\Http\Resources\ResourceIncludes
 */
class CommentResourceIncludes extends ResourceIncludes
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'owner',
        'favorites',
    ];
}
