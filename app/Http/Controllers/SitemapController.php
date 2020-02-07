<?php

namespace App\Http\Controllers;

use App\Services\SitemapService;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    /**
     * @var SitemapService
     */
    protected $sitemapService;

    /**
     * SitemapController constructor.
     * @param SitemapService $sitemapService
     */
    public function __construct(SitemapService $sitemapService)
    {
        $this->sitemapService = $sitemapService;
    }

    public function index()
    {
        $urls = $this->sitemapService->getUrls();

        \Illuminate\Support\Facades\Request::header('Content-Type : text/xml');
        return response()->view('sitemap.index', compact('urls'))
            ->header('Content-type', 'text/xml');
    }
}
