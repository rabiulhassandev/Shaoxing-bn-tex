<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $staticUrls = [
            route('home'),
            route('about'),
            route('sourcing'),
            route('sustainability'),
            route('buyers'),
            route('fabrics.index'),
            route('news.index'),
            route('contact'),
        ];

        return response()
            ->view('sitemap', [
                'staticUrls' => $staticUrls,
                'fabrics' => Fabric::query()->active()->get(['slug', 'updated_at']),
                'posts' => Post::query()->published()->get(['slug', 'updated_at']),
            ])
            ->header('Content-Type', 'application/xml');
    }
}
