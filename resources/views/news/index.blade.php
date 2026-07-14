@extends('layouts.public')

@section('title', 'News')
@section('meta_description', 'Company updates, trade-fair announcements and textile industry news from SHAOXING BN TEX.')

@section('content')
    <div class="border-b border-stone-200 bg-stone-50">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="News" title="News & Updates"
                subtitle="Company announcements, trade-fair schedules and market notes for fabric buyers." />
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($posts->isNotEmpty())
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="group overflow-hidden rounded-lg border border-stone-200 bg-white transition hover:border-brand-300 hover:shadow-sm">
                        <a href="{{ route('news.show', $post) }}" class="block aspect-[16/9] overflow-hidden bg-stone-100" tabindex="-1" aria-hidden="true">
                            @if ($post->image_url)
                                <img src="{{ $post->image_url }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]">
                            @endif
                        </a>
                        <div class="p-5">
                            <p class="text-xs font-medium text-stone-500">{{ $post->published_at->format('d M Y') }}</p>
                            <h2 class="mt-2 font-semibold leading-snug text-stone-900">
                                <a href="{{ route('news.show', $post) }}" class="transition hover:text-brand-800">{{ $post->title }}</a>
                            </h2>
                            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-stone-600">{{ $post->excerpt }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-10">{{ $posts->links() }}</div>
        @else
            <p class="py-20 text-center text-stone-500">No news published yet — check back soon.</p>
        @endif
    </div>
@endsection
