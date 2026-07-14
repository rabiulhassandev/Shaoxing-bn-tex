<?php

namespace App\Http\Controllers;

use App\Enums\PartnerType;
use App\Models\Fabric;
use App\Models\HeroSlide;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Stat;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'slides' => HeroSlide::query()->active()->ordered()->get(),
            'stats' => Stat::query()->ordered()->get(),
            'featuredFabrics' => Fabric::query()->active()->featured()->with('category')->orderBy('sort_order')->take(8)->get(),
            'buyers' => Partner::query()->active()->ofType(PartnerType::Buyer)->ordered()->get(),
            'vendors' => Partner::query()->active()->ofType(PartnerType::Vendor)->ordered()->get(),
            'posts' => Post::query()->published()->latest('published_at')->take(3)->get(),
        ]);
    }
}
