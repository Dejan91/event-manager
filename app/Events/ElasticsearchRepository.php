<?php

namespace App\Events;

use App\Event;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class ElasticsearchRepository extends ElasticsearchFilters implements EventsRepository
{
    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    protected $request;

    /**
     * @var array
     */
    protected $filters = [
        'title',
        'description',
    ];

    public function __construct(Client $elasticsearch, Request $request)
    {
        $this->elasticsearch = $elasticsearch;

        $this->request = $request;
    }

    public function title($title)
    {
        $title = $title ?: '';

        $model = new Event;

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'match' => [
                        'title' => [
                            'query' => $title,
                        ],
                    ],
                ],
            ],
        ]);

        return $this->buildCollection($items);
    }

    public function description($description)
    {
        $description = $description ?: '';
        $model = new Event;
        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'match' => [
                        'description' => [
                            'query' => $description,
                        ],
                    ],
                ],
            ],
        ]);

        return $this->buildCollection($items);
    }

    private function buildCollection($items)
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Event::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}