<?php

namespace App\Containers\Sitemap\Http\Controllers;

use App\Containers\Sitemap\Services\SitemapService;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Http\Response;

class SitemapController extends WebController
{
    /**
     * @var SitemapService
     */
    protected $sitemapService;

    /**
     * SitemapController constructor.
     *
     * @param SitemapService $sitemapService
     */
    public function __construct(SitemapService $sitemapService)
    {
        $this->sitemapService = $sitemapService;
    }

    public function index(): Response
    {
        $urls = $this->sitemapService->getUrls();

        \Illuminate\Support\Facades\Request::header('Content-Type : text/xml');
        return response()->view('sitemap.index', compact('urls'))
            ->header('Content-type', 'text/xml');
    }
}
