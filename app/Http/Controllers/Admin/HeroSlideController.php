<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroSlideRequest;
use App\Models\HeroSlide;
use App\Services\ImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function __construct(private ImageStorage $images) {}

    public function index(): View
    {
        return view('admin.hero-slides.index', [
            'slides' => HeroSlide::query()->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.hero-slides.form', ['slide' => new HeroSlide]);
    }

    public function store(HeroSlideRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image']);
        $data['image'] = $this->images->store($request->file('image'), 'hero');

        HeroSlide::query()->create($data);

        return redirect()->route('admin.hero-slides.index')->with('status', 'Hero slide created.');
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.form', ['slide' => $heroSlide]);
    }

    public function update(HeroSlideRequest $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $request->safe()->except(['image']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->replace($heroSlide->image, $request->file('image'), 'hero');
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('status', 'Hero slide updated.');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        $this->images->delete($heroSlide->image);
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('status', 'Hero slide deleted.');
    }
}
