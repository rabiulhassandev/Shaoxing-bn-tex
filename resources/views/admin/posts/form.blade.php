@extends('layouts.admin')

@section('title', $post->exists ? 'Edit Post' : 'Add Post')

@section('content')
    <form method="POST" enctype="multipart/form-data"
        action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
        class="max-w-3xl space-y-5 rounded-lg border border-stone-200 bg-white p-6">
        @csrf
        @if ($post->exists)
            @method('PUT')
        @endif

        <div>
            <x-input-label for="title" value="Title" />
            <x-text-input id="title" name="title" class="mt-1" :value="old('title', $post->title)" required />
            <x-input-error :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="slug" value="Slug" />
            <x-text-input id="slug" name="slug" class="mt-1" :value="old('slug', $post->slug)" placeholder="Leave blank to generate from title" />
            <x-input-error :messages="$errors->get('slug')" />
        </div>

        <div>
            <x-input-label for="excerpt" value="Excerpt (shown on listing cards)" />
            <x-textarea-input id="excerpt" name="excerpt" rows="2" class="mt-1">{{ old('excerpt', $post->excerpt) }}</x-textarea-input>
            <x-input-error :messages="$errors->get('excerpt')" />
        </div>

        <div>
            <x-input-label for="body" value="Body" />
            <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
            <trix-editor input="body" class="mt-1 rounded-md border border-stone-300"></trix-editor>
            <x-input-error :messages="$errors->get('body')" />
        </div>

        <div class="grid grid-cols-1 items-end gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="image" value="Cover image" />
                @if ($post->image_url)
                    <img src="{{ $post->image_url }}" alt="" class="mt-2 h-24 w-40 rounded object-cover">
                @endif
                <input id="image" name="image" type="file" accept="image/*"
                    class="mt-2 block w-full text-sm text-stone-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
                <x-input-error :messages="$errors->get('image')" />
            </div>
            <div>
                <x-input-label for="published_at" value="Publish date (optional)" />
                <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1"
                    :value="old('published_at', $post->published_at?->format('Y-m-d\TH:i'))" />
                <x-input-error :messages="$errors->get('published_at')" />
            </div>
        </div>

        <label class="flex items-center gap-2">
            <input type="hidden" name="is_published" value="0">
            <x-checkbox-input name="is_published" value="1" :checked="(bool) old('is_published', $post->is_published ?? false)" />
            <span class="text-sm text-stone-700">Published (visible on the website)</span>
        </label>

        <div class="flex items-center gap-3 border-t border-stone-100 pt-5">
            <x-primary-button>{{ $post->exists ? 'Save changes' : 'Create post' }}</x-primary-button>
            <a href="{{ route('admin.posts.index') }}" class="text-sm font-medium text-stone-600 hover:text-stone-900">Cancel</a>
        </div>
    </form>
@endsection
