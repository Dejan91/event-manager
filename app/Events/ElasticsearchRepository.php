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
        parent::__construct($request);

        $this->elasticsearch = $elasticsearch;

        $this->request = $request;
    }

    public function all()
    {
        $this->events[] = Event::latest()->get();
    }

    public function title($title)
    {
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

        $this->events[] = $this->buildCollection($items);
    }

    public function description($description)
    {
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

        $this->events[] = $this->buildCollection($items);
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
