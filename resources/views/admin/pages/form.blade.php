@extends('layouts.admin')

@section('title', 'Edit Page: '.$page->title)

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.update', $page) }}"
        class="max-w-3xl space-y-5 rounded-lg border border-stone-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="title" value="Page title" />
            <x-text-input id="title" name="title" class="mt-1" :value="old('title', $page->title)" required />
            <x-input-error :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="intro" value="Intro (shown under the page title)" />
            <x-textarea-input id="intro" name="intro" rows="2" class="mt-1">{{ old('intro', $page->intro) }}</x-textarea-input>
            <x-input-error :messages="$errors->get('intro')" />
        </div>

        <div>
            <x-input-label for="body" value="Body" />
            <input id="body" type="hidden" name="body" value="{{ old('body', $page->body) }}">
            <trix-editor input="body" class="mt-1 rounded-md border border-stone-300"></trix-editor>
            <x-input-error :messages="$errors->get('body')" />
        </div>

        <div>
            <x-input-label for="banner_image" value="Banner image (optional)" />
            @if ($page->banner_url)
                <img src="{{ $page->banner_url }}" alt="" class="mt-2 h-24 w-48 rounded object-cover">
            @endif
            <input id="banner_image" name="banner_image" type="file" accept="image/*"
                class="mt-2 block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
            <x-input-error :messages="$errors->get('banner_image')" />
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="meta_title" value="Meta title (SEO)" />
                <x-text-input id="meta_title" name="meta_title" class="mt-1" :value="old('meta_title', $page->meta_title)" />
                <x-input-error :messages="$errors->get('meta_title')" />
            </div>
            <div>
                <x-input-label for="meta_description" value="Meta description (SEO)" />
                <x-text-input id="meta_description" name="meta_description" class="mt-1" :value="old('meta_description', $page->meta_description)" />
                <x-input-error :messages="$errors->get('meta_description')" />
            </div>
        </div>

        <div class="flex items-center gap-3 border-t border-stone-100 pt-5">
            <x-primary-button>Save changes</x-primary-button>
            <a href="{{ route('admin.pages.index') }}" class="text-sm font-medium text-stone-600 hover:text-stone-900">Cancel</a>
        </div>
    </form>
@endsection
