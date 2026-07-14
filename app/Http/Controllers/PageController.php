<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Stat;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        return view('pages.show', [
            'page' => Page::query()->where('slug', $slug)->firstOrFail(),
            'stats' => $slug === 'about' ? Stat::query()->ordered()->get() : collect(),
        ]);
    }
}
