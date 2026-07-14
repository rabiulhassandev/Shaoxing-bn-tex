<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('news.index', [
            'posts' => Post::query()->published()->latest('published_at')->paginate(9),
        ]);
    }

    public function show(Post $post): View
    {
        abort_unless($post->is_published && $post->published_at?->isPast(), 404);

        return view('news.show', [
            'post' => $post,
            'recentPosts' => Post::query()->published()->whereKeyNot($post->id)->latest('published_at')->take(3)->get(),
        ]);
    }
}
