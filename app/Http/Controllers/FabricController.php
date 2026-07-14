<?php

namespace App\Http\Controllers;

use App\Models\Fabric;
use App\Models\FabricCategory;
use App\Services\InquiryBasket;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FabricController extends Controller
{
    public function index(Request $request, InquiryBasket $basket): View
    {
        $categories = FabricCategory::query()
            ->active()
            ->ordered()
            ->withCount(['fabrics' => fn ($query) => $query->where('is_active', true)])
            ->get();

        $currentCategory = $categories->firstWhere('slug', $request->string('category')->toString());

        $fabrics = Fabric::query()
            ->active()
            ->with('category')
            ->when($currentCategory, fn ($query) => $query->where('category_id', $currentCategory->id))
            ->when($request->filled('search'), fn ($query) => $query->search($request->string('search')))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('fabrics.index', [
            'fabrics' => $fabrics,
            'categories' => $categories,
            'currentCategory' => $currentCategory,
            'basketIds' => $basket->ids(),
        ]);
    }

    public function show(Fabric $fabric, InquiryBasket $basket): View
    {
        abort_unless($fabric->is_active, 404);

        $fabric->load(['category', 'images']);

        return view('fabrics.show', [
            'fabric' => $fabric,
            'inBasket' => $basket->contains($fabric),
            'relatedFabrics' => Fabric::query()
                ->active()
                ->with('category')
                ->where('category_id', $fabric->category_id)
                ->whereKeyNot($fabric->id)
                ->orderBy('sort_order')
                ->take(4)
                ->get(),
        ]);
    }
}
