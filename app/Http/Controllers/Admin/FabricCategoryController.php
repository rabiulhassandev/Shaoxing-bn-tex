<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FabricCategoryRequest;
use App\Models\FabricCategory;
use App\Services\ImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FabricCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => FabricCategory::query()->withCount('fabrics')->ordered()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.form', ['category' => new FabricCategory]);
    }

    public function store(FabricCategoryRequest $request): RedirectResponse
    {
        FabricCategory::query()->create($request->validated());

        return redirect()->route('admin.categories.index')->with('status', 'Category created.');
    }

    public function edit(FabricCategory $category): View
    {
        return view('admin.categories.form', ['category' => $category]);
    }

    public function update(FabricCategoryRequest $request, FabricCategory $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with('status', 'Category updated.');
    }

    public function destroy(FabricCategory $category, ImageStorage $images): RedirectResponse
    {
        $category->load('fabrics.images');

        foreach ($category->fabrics as $fabric) {
            $images->delete($fabric->image);

            foreach ($fabric->images as $galleryImage) {
                $images->delete($galleryImage->path);
            }
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Category and its fabrics deleted.');
    }
}
