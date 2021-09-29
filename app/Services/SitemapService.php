<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class SitemapService
{
    /**
     * @var Collection
     */
    protected $urls;

    public function __construct()
    {
        $this->urls = collect();
    }

    public function getUrls(): Collection
    {
        $this->addPage(route('main'));

        return $this->urls;
    }

    /**
     * @param string $url
     */
    public function addPage(string $url)
    {
        $this->urls->push([
            'url' => $url,
            'date' => Carbon::now(),
        ]);
    }

    /**
     * @param Collection $collection
     * @param callable $urlCallback
     */
    public function addModel(Collection $collection, callable $urlCallback)
    {
        $modelsUrls = $collection->map(function ($model) use ($urlCallback) {
            return [
                'url' => $urlCallback($model),
                'date' => $model->updated_at ?? Carbon::now(),
            ];
        });

        $this->urls = $this->urls->concat($modelsUrls);
    }
}
