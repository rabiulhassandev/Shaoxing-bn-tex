<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use App\Services\ImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(private ImageStorage $images) {}

    public function index(): View
    {
        return view('admin.pages.index', [
            'pages' => Page::query()->orderBy('title')->get(),
        ]);
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.form', ['page' => $page]);
    }

    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        $data = $request->safe()->except(['banner_image']);

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $this->images->replace($page->banner_image, $request->file('banner_image'), 'pages');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('status', 'Page updated.');
    }
}
