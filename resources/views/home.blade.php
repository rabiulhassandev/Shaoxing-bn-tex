@extends('layouts.public')

@section('meta_description', $settings['meta_description'] ?? '')

@section('content')
    @if ($slides->isNotEmpty())
        <section x-data="slider({{ $slides->count() }})" class="relative h-[70vh] min-h-[440px] max-h-[640px] overflow-hidden bg-brand-950" aria-label="Highlights">
            @foreach ($slides as $slide)
                <div x-show="active === {{ $loop->index }}" x-transition:enter="transition duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="absolute inset-0" @if (! $loop->first) x-cloak @endif>
                    <img src="{{ $slide->image_url }}" alt="" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-brand-950/80 via-brand-950/50 to-transparent"></div>
                    <div class="relative mx-auto flex h-full max-w-7xl items-center px-4 sm:px-6 lg:px-8">
                        <div class="max-w-xl">
                            <h1 class="text-3xl font-bold leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl">{{ $slide->title }}</h1>
                            @if ($slide->subtitle)
                                <p class="mt-4 text-base leading-relaxed text-stone-200 sm:text-lg">{{ $slide->subtitle }}</p>
                            @endif
                            @if ($slide->button_text && $slide->button_url)
                                <a href="{{ url($slide->button_url) }}"
                                    class="mt-8 inline-flex items-center gap-2 rounded-md bg-white px-5 py-3 text-sm font-semibold text-brand-900 transition hover:bg-stone-100">
                                    {{ $slide->button_text }}
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12l-7.5 7.5M21 12H3" /></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($slides->count() > 1)
                <div class="absolute bottom-6 left-1/2 z-10 flex -translate-x-1/2 gap-2">
                    @foreach ($slides as $slide)
                        <button type="button" @click="go({{ $loop->index }})"
                            :class="active === {{ $loop->index }} ? 'bg-white' : 'bg-white/40'"
                            class="h-1.5 w-8 rounded-full transition" aria-label="Go to slide {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    @if ($stats->isNotEmpty())
        <section class="border-b border-stone-200 bg-stone-50" aria-label="Key figures">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-px px-4 py-10 sm:px-6 lg:grid-cols-4 lg:px-8">
                @foreach ($stats as $stat)
                    <div class="px-4 py-3 text-center">
                        <p class="text-3xl font-bold tracking-tight text-brand-800 sm:text-4xl">{{ $stat->value }}<span class="text-brand-500">{{ $stat->suffix }}</span></p>
                        <p class="mt-1 text-sm font-medium text-stone-500">{{ $stat->label }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-2 lg:gap-16">
            <x-section-heading eyebrow="Who we are" :title="$settings['home_intro_heading'] ?? 'A trading partner, not just a supplier'" />
            <div>
                <p class="text-base leading-relaxed text-stone-600">{{ $settings['home_intro_text'] ?? '' }}</p>
                <div class="mt-6 flex flex-wrap gap-4">
                    <a href="{{ route('about') }}" class="text-sm font-semibold text-brand-700 transition hover:text-brand-800">More about us &rarr;</a>
                    <a href="{{ route('sourcing') }}" class="text-sm font-semibold text-brand-700 transition hover:text-brand-800">How we source &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    @if ($featuredFabrics->isNotEmpty())
        <section class="bg-stone-50 py-16 lg:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <x-section-heading eyebrow="Featured fabrics" title="From our catalogue"
                        subtitle="A selection of our most requested qualities. Browse the full catalogue to filter by composition and search by name." />
                    <a href="{{ route('fabrics.index') }}" class="text-sm font-semibold text-brand-700 transition hover:text-brand-800">View full catalogue &rarr;</a>
                </div>
                <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($featuredFabrics as $fabric)
                        <x-fabric-card :fabric="$fabric" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($buyers->isNotEmpty() || $vendors->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            @if ($buyers->isNotEmpty())
                <x-section-heading :center="true" eyebrow="Trusted worldwide" title="Brands & buyers we serve" />
                <x-logo-wall :partners="$buyers" class="mt-10" />
            @endif
            @if ($vendors->isNotEmpty())
                <div class="mt-16">
                    <x-section-heading :center="true" eyebrow="Our supply network" title="Partner mills & vendors" />
                    <x-logo-wall :partners="$vendors" class="mt-10" />
                </div>
            @endif
        </section>
    @endif

    @if ($posts->isNotEmpty())
        <section class="bg-stone-50 py-16 lg:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <x-section-heading eyebrow="News" title="Latest from BN TEX" />
                    <a href="{{ route('news.index') }}" class="text-sm font-semibold text-brand-700 transition hover:text-brand-800">All news &rarr;</a>
                </div>
                <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach ($posts as $post)
                        <article class="group overflow-hidden rounded-lg border border-stone-200 bg-white transition hover:border-brand-300 hover:shadow-sm">
                            <a href="{{ route('news.show', $post) }}" class="block aspect-[16/9] overflow-hidden bg-stone-100" tabindex="-1" aria-hidden="true">
                                @if ($post->image_url)
                                    <img src="{{ $post->image_url }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]">
                                @endif
                            </a>
                            <div class="p-5">
                                <p class="text-xs font-medium text-stone-500">{{ $post->published_at->format('d M Y') }}</p>
                                <h3 class="mt-2 font-semibold leading-snug text-stone-900">
                                    <a href="{{ route('news.show', $post) }}" class="transition hover:text-brand-800">{{ $post->title }}</a>
                                </h3>
                                <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-stone-600">{{ $post->excerpt }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-brand-900">
        <div class="mx-auto flex max-w-7xl flex-col items-center gap-6 px-4 py-16 text-center sm:px-6 lg:px-8">
            <h2 class="max-w-2xl text-2xl font-bold tracking-tight text-white sm:text-3xl">Ready to source your next fabric programme?</h2>
            <p class="max-w-xl text-base leading-relaxed text-stone-300">Browse the catalogue, add fabrics to your inquiry basket and receive one consolidated quotation — usually within one working day.</p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('fabrics.index') }}" class="rounded-md bg-white px-5 py-3 text-sm font-semibold text-brand-900 transition hover:bg-stone-100">Browse fabrics</a>
                <a href="{{ route('contact') }}" class="rounded-md border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">Contact us</a>
            </div>
        </div>
    </section>
@endsection
