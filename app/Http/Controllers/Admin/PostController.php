<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use App\Services\ImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(private ImageStorage $images) {}

    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::query()->latest('published_at')->latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', ['post' => new Post]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        Post::query()->create($this->preparedData($request));

        return redirect()->route('admin.posts.index')->with('status', 'News post created.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.form', ['post' => $post]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $post->update($this->preparedData($request, $post));

        return redirect()->route('admin.posts.index')->with('status', 'News post updated.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->images->delete($post->image);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'News post deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function preparedData(PostRequest $request, ?Post $post = null): array
    {
        $data = $request->safe()->except(['image']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->replace($post?->image, $request->file('image'), 'posts');
        }

        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
