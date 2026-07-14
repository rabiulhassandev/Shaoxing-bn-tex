<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FabricRequest;
use App\Models\Fabric;
use App\Models\FabricCategory;
use App\Models\FabricImage;
use App\Services\ImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FabricController extends Controller
{
    public function __construct(private ImageStorage $images) {}

    public function index(Request $request): View
    {
        $fabrics = Fabric::query()
            ->with('category')
            ->when($request->filled('search'), fn ($query) => $query->search($request->string('search')))
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.fabrics.index', [
            'fabrics' => $fabrics,
            'categories' => FabricCategory::query()->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.fabrics.form', [
            'fabric' => new Fabric,
            'categories' => FabricCategory::query()->ordered()->get(),
        ]);
    }

    public function store(FabricRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['gallery', 'image']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), 'fabrics');
        }

        $fabric = Fabric::query()->create($data);
        $this->storeGallery($fabric, $request);

        return redirect()->route('admin.fabrics.index')->with('status', 'Fabric created.');
    }

    public function edit(Fabric $fabric): View
    {
        return view('admin.fabrics.form', [
            'fabric' => $fabric->load('images'),
            'categories' => FabricCategory::query()->ordered()->get(),
        ]);
    }

    public function update(FabricRequest $request, Fabric $fabric): RedirectResponse
    {
        $data = $request->safe()->except(['gallery', 'image']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->replace($fabric->image, $request->file('image'), 'fabrics');
        }

        $fabric->update($data);
        $this->storeGallery($fabric, $request);

        return redirect()->route('admin.fabrics.index')->with('status', 'Fabric updated.');
    }

    public function destroy(Fabric $fabric): RedirectResponse
    {
        $this->images->delete($fabric->image);

        foreach ($fabric->images as $galleryImage) {
            $this->images->delete($galleryImage->path);
        }

        $fabric->delete();

        return redirect()->route('admin.fabrics.index')->with('status', 'Fabric deleted.');
    }

    public function destroyImage(FabricImage $fabricImage): RedirectResponse
    {
        $this->images->delete($fabricImage->path);
        $fabricImage->delete();

        return back()->with('status', 'Gallery image removed.');
    }

    private function storeGallery(Fabric $fabric, FabricRequest $request): void
    {
        foreach ($request->file('gallery', []) as $file) {
            $fabric->images()->create(['path' => $this->images->store($file, 'fabrics')]);
        }
    }
}
