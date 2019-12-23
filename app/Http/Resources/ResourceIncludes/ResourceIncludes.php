<?php

namespace App\Http\Resources\ResourceIncludes;

use Illuminate\Http\Request;

/**
 * Class ResourceIncludes
 * @package App\Http\Resources\ResourceIncludes
 */
abstract class ResourceIncludes
{
    /**
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * @param $resource
     * @param Request|null $request
     * @return mixed
     */
    public function attach($resource, Request $request = null)
    {
        $request = $request ?? app('request');

        return tap($resource, function ($resource) use ($request) {
            $this->getRequestIncludes($request)
                ->each(function ($include) use ($resource) {
                    if (! trim($include) == '') $resource->load($include);
                });
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    protected function getRequestIncludes(Request $request)
    {
        $param = data_get($request->input(), 'include', []);

        $exploded = empty($param) || trim($param) === ''
            ? ''
            : explode(',', $param);

        return collect($exploded)->filter(function ($exploded) {
            return in_array($exploded, $this->availableIncludes);
        });
    }
}
