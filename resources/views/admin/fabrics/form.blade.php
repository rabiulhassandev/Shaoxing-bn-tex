@extends('layouts.admin')

@section('title', $fabric->exists ? 'Edit Fabric' : 'Add Fabric')

@section('content')
    <form method="POST" enctype="multipart/form-data"
        action="{{ $fabric->exists ? route('admin.fabrics.update', $fabric) : route('admin.fabrics.store') }}"
        class="max-w-3xl space-y-5 rounded-lg border border-stone-200 bg-white p-6">
        @csrf
        @if ($fabric->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="name" value="Fabric name" />
                <x-text-input id="name" name="name" class="mt-1" :value="old('name', $fabric->name)" required />
                <x-input-error :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="category_id" value="Category" />
                <x-select-input id="category_id" name="category_id" class="mt-1" required>
                    <option value="">Select a category…</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $fabric->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('category_id')" />
            </div>
        </div>

        <div>
            <x-input-label for="slug" value="Slug" />
            <x-text-input id="slug" name="slug" class="mt-1" :value="old('slug', $fabric->slug)" placeholder="Leave blank to generate from name" />
            <x-input-error :messages="$errors->get('slug')" />
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            @foreach ([
                'construction' => 'Construction (e.g. 40x40 133x72)',
                'composition' => 'Composition (e.g. 100% Cotton)',
                'width' => 'Width (e.g. 57/58")',
                'weight' => 'Weight (e.g. 120 GSM / 10 OZ)',
                'finish' => 'Finish',
                'colors' => 'Available colours',
                'moq' => 'MOQ',
                'lead_time' => 'Lead time',
            ] as $field => $label)
                <div>
                    <x-input-label :for="$field" :value="$label" />
                    <x-text-input :id="$field" :name="$field" class="mt-1" :value="old($field, $fabric->{$field})" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>
            @endforeach
        </div>

        <div>
            <x-input-label for="description" value="Description" />
            <x-textarea-input id="description" name="description" rows="4" class="mt-1">{{ old('description', $fabric->description) }}</x-textarea-input>
            <x-input-error :messages="$errors->get('description')" />
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="image" value="Main image" />
                @if ($fabric->image_url)
                    <img src="{{ $fabric->image_url }}" alt="" class="mt-2 h-24 w-32 rounded object-cover">
                @endif
                <input id="image" name="image" type="file" accept="image/*"
                    class="mt-2 block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
                <x-input-error :messages="$errors->get('image')" />
            </div>
            <div>
                <x-input-label for="gallery" value="Add gallery images (up to 8)" />
                <input id="gallery" name="gallery[]" type="file" accept="image/*" multiple
                    class="mt-2 block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
                <x-input-error :messages="$errors->get('gallery')" />
                <x-input-error :messages="$errors->get('gallery.*')" />
            </div>
        </div>

        <div class="flex flex-wrap items-end gap-6">
            <div class="w-32">
                <x-input-label for="sort_order" value="Sort order" />
                <x-text-input id="sort_order" name="sort_order" type="number" min="0" class="mt-1" :value="old('sort_order', $fabric->sort_order ?? 0)" />
                <x-input-error :messages="$errors->get('sort_order')" />
            </div>
            <label class="flex items-center gap-2 pb-2">
                <input type="hidden" name="is_active" value="0">
                <x-checkbox-input name="is_active" value="1" :checked="(bool) old('is_active', $fabric->is_active ?? true)" />
                <span class="text-sm text-stone-700">Active</span>
            </label>
            <label class="flex items-center gap-2 pb-2">
                <input type="hidden" name="is_featured" value="0">
                <x-checkbox-input name="is_featured" value="1" :checked="(bool) old('is_featured', $fabric->is_featured ?? false)" />
                <span class="text-sm text-stone-700">Featured on homepage</span>
            </label>
        </div>

        <div class="flex items-center gap-3 border-t border-stone-100 pt-5">
            <x-primary-button>{{ $fabric->exists ? 'Save changes' : 'Create fabric' }}</x-primary-button>
            <a href="{{ route('admin.fabrics.index') }}" class="text-sm font-medium text-stone-600 hover:text-stone-900">Cancel</a>
        </div>
    </form>

    @if ($fabric->exists && $fabric->images->isNotEmpty())
        <section class="mt-6 max-w-3xl rounded-lg border border-stone-200 bg-white p-6">
            <h2 class="text-sm font-semibold text-stone-900">Gallery images</h2>
            <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
                @foreach ($fabric->images as $galleryImage)
                    <div class="space-y-2">
                        <img src="{{ $galleryImage->url }}" alt="" class="h-24 w-full rounded object-cover">
                        <x-admin.delete-button :action="route('admin.fabric-images.destroy', $galleryImage)" confirm="Remove this gallery image?">Remove</x-admin.delete-button>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection
