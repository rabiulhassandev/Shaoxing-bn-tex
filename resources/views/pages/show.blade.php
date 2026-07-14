@extends('layouts.public')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?? '')

@section('content')
    <div class="border-b border-stone-200 bg-stone-50">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-section-heading :title="$page->title" :subtitle="$page->intro" />
        </div>
    </div>

    @if ($page->banner_url)
        <div class="mx-auto max-w-7xl px-4 pt-10 sm:px-6 lg:px-8">
            <img src="{{ $page->banner_url }}" alt="" class="max-h-96 w-full rounded-lg object-cover">
        </div>
    @endif

    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rich-text text-stone-700">
            {!! $page->body !!}
        </div>
    </div>

    @if ($stats->isNotEmpty())
        <section class="border-t border-stone-200 bg-stone-50" aria-label="Key figures">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-px px-4 py-10 sm:px-6 lg:grid-cols-4 lg:px-8">
                @foreach ($stats as $stat)
                    <div class="px-4 py-3 text-center">
                        <p class="text-3xl font-bold tracking-tight text-brand-800">{{ $stat->value }}<span class="text-brand-500">{{ $stat->suffix }}</span></p>
                        <p class="mt-1 text-sm font-medium text-stone-500">{{ $stat->label }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection
