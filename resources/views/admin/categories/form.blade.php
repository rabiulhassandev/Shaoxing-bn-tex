@extends('layouts.admin')

@section('title', $category->exists ? 'Edit Category' : 'Add Category')

@section('content')
    <form method="POST"
        action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
        class="max-w-2xl space-y-5 rounded-lg border border-stone-200 bg-white p-6">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" name="name" class="mt-1" :value="old('name', $category->name)" required />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="slug" value="Slug" />
            <x-text-input id="slug" name="slug" class="mt-1" :value="old('slug', $category->slug)" placeholder="Leave blank to generate from name" />
            <x-input-error :messages="$errors->get('slug')" />
        </div>

        <div>
            <x-input-label for="description" value="Description (optional)" />
            <x-textarea-input id="description" name="description" rows="3" class="mt-1">{{ old('description', $category->description) }}</x-textarea-input>
            <x-input-error :messages="$errors->get('description')" />
        </div>

        <div class="flex flex-wrap items-end gap-6">
            <div class="w-32">
                <x-input-label for="sort_order" value="Sort order" />
                <x-text-input id="sort_order" name="sort_order" type="number" min="0" class="mt-1" :value="old('sort_order', $category->sort_order ?? 0)" />
                <x-input-error :messages="$errors->get('sort_order')" />
            </div>
            <label class="flex items-center gap-2 pb-2">
                <input type="hidden" name="is_active" value="0">
                <x-checkbox-input name="is_active" value="1" :checked="(bool) old('is_active', $category->is_active ?? true)" />
                <span class="text-sm text-stone-700">Active (visible on the website)</span>
            </label>
        </div>

        <div class="flex items-center gap-3 border-t border-stone-100 pt-5">
            <x-primary-button>{{ $category->exists ? 'Save changes' : 'Create category' }}</x-primary-button>
            <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-stone-600 hover:text-stone-900">Cancel</a>
        </div>
    </form>
@endsection
