@extends('layouts.public')

@section('title', $post->title)
@section('meta_description', Str::limit($post->excerpt, 155))
@section('og_type', 'article')
@if ($post->image_url)
    @section('og_image', $post->image_url)
@endif

@section('content')
    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <a href="{{ route('news.index') }}" class="text-sm font-medium text-brand-700 transition hover:text-brand-800">&larr; All news</a>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-stone-900 sm:text-4xl">{{ $post->title }}</h1>
        <p class="mt-3 text-sm text-stone-500">
            <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('d F Y') }}</time>
        </p>

        @if ($post->image_url)
            <img src="{{ $post->image_url }}" alt="" class="mt-8 aspect-[16/9] w-full rounded-lg object-cover">
        @endif

        <div class="rich-text mt-8 text-stone-700">
            {!! $post->body !!}
        </div>
    </article>

    @if ($recentPosts->isNotEmpty())
        <section class="border-t border-stone-200 bg-stone-50 py-14">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <x-section-heading eyebrow="More" title="Recent news" />
                <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach ($recentPosts as $recentPost)
                        <article class="rounded-lg border border-stone-200 bg-white p-5 transition hover:border-brand-300">
                            <p class="text-xs font-medium text-stone-500">{{ $recentPost->published_at->format('d M Y') }}</p>
                            <h3 class="mt-2 font-semibold leading-snug text-stone-900">
                                <a href="{{ route('news.show', $recentPost) }}" class="transition hover:text-brand-800">{{ $recentPost->title }}</a>
                            </h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
