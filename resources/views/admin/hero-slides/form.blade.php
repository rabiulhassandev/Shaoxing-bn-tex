@extends('layouts.admin')

@section('title', $slide->exists ? 'Edit Slide' : 'Add Slide')

@section('content')
    <form method="POST" enctype="multipart/form-data"
        action="{{ $slide->exists ? route('admin.hero-slides.update', $slide) : route('admin.hero-slides.store') }}"
        class="max-w-2xl space-y-5 rounded-lg border border-stone-200 bg-white p-6">
        @csrf
        @if ($slide->exists)
            @method('PUT')
        @endif

        <div>
            <x-input-label for="title" value="Title" />
            <x-text-input id="title" name="title" class="mt-1" :value="old('title', $slide->title)" required />
            <x-input-error :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="subtitle" value="Subtitle (optional)" />
            <x-textarea-input id="subtitle" name="subtitle" rows="2" class="mt-1">{{ old('subtitle', $slide->subtitle) }}</x-textarea-input>
            <x-input-error :messages="$errors->get('subtitle')" />
        </div>

        <div>
            <x-input-label for="image" value="Background image {{ $slide->exists ? '(leave empty to keep current)' : '' }}" />
            @if ($slide->exists)
                <img src="{{ $slide->image_url }}" alt="" class="mt-2 h-24 w-48 rounded object-cover">
            @endif
            <input id="image" name="image" type="file" accept="image/*" @required(! $slide->exists)
                class="mt-2 block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
            <x-input-error :messages="$errors->get('image')" />
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="button_text" value="Button text (optional)" />
                <x-text-input id="button_text" name="button_text" class="mt-1" :value="old('button_text', $slide->button_text)" />
                <x-input-error :messages="$errors->get('button_text')" />
            </div>
            <div>
                <x-input-label for="button_url" value="Button link (optional)" />
                <x-text-input id="button_url" name="button_url" class="mt-1" :value="old('button_url', $slide->button_url)" placeholder="/fabrics" />
                <x-input-error :messages="$errors->get('button_url')" />
            </div>
        </div>

        <div class="flex flex-wrap items-end gap-6">
            <div class="w-32">
                <x-input-label for="sort_order" value="Sort order" />
                <x-text-input id="sort_order" name="sort_order" type="number" min="0" class="mt-1" :value="old('sort_order', $slide->sort_order ?? 0)" />
                <x-input-error :messages="$errors->get('sort_order')" />
            </div>
            <label class="flex items-center gap-2 pb-2">
                <input type="hidden" name="is_active" value="0">
                <x-checkbox-input name="is_active" value="1" :checked="(bool) old('is_active', $slide->is_active ?? true)" />
                <span class="text-sm text-stone-700">Active</span>
            </label>
        </div>

        <div class="flex items-center gap-3 border-t border-stone-100 pt-5">
            <x-primary-button>{{ $slide->exists ? 'Save changes' : 'Create slide' }}</x-primary-button>
            <a href="{{ route('admin.hero-slides.index') }}" class="text-sm font-medium text-stone-600 hover:text-stone-900">Cancel</a>
        </div>
    </form>
@endsection
