@extends('layouts.public')

@section('title', $fabric->name)
@section('meta_description', Str::limit($fabric->description, 155) ?: $fabric->name.' — '.$fabric->composition.' fabric available from stock or made to order.')
@section('og_type', 'product')
@if ($fabric->image_url)
    @section('og_image', $fabric->image_url)
@endif

@php
    $galleryImages = collect([$fabric->image_url])->filter()->merge($fabric->images->pluck('url'))->values();
@endphp

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="text-sm text-stone-500" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('fabrics.index') }}" class="transition hover:text-stone-900">Fabric Catalogue</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="{{ route('fabrics.index', ['category' => $fabric->category->slug]) }}" class="transition hover:text-stone-900">{{ $fabric->category->name }}</a></li>
                <li aria-hidden="true">/</li>
                <li class="font-medium text-stone-900" aria-current="page">{{ $fabric->name }}</li>
            </ol>
        </nav>

        <div class="mt-8 grid grid-cols-1 gap-10 lg:grid-cols-2 lg:gap-14">
            <div x-data="{ images: {{ Js::from($galleryImages) }}, active: 0 }">
                <div class="aspect-[4/3] overflow-hidden rounded-lg border border-stone-200 bg-stone-100">
                    @if ($galleryImages->isNotEmpty())
                        <img :src="images[active]" src="{{ $galleryImages->first() }}" alt="{{ $fabric->name }}" class="h-full w-full object-cover">
                    @endif
                </div>
                @if ($galleryImages->count() > 1)
                    <div class="mt-3 grid grid-cols-5 gap-3">
                        @foreach ($galleryImages as $imageUrl)
                            <button type="button" @click="active = {{ $loop->index }}"
                                :class="active === {{ $loop->index }} ? 'ring-2 ring-brand-600' : 'ring-1 ring-stone-200 hover:ring-brand-300'"
                                class="aspect-square overflow-hidden rounded-md transition" aria-label="View image {{ $loop->iteration }}">
                                <img src="{{ $imageUrl }}" alt="" loading="lazy" class="h-full w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-600">{{ $fabric->category->name }}</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-stone-900">{{ $fabric->name }}</h1>
                @if ($fabric->description)
                    <p class="mt-4 text-base leading-relaxed text-stone-600">{{ $fabric->description }}</p>
                @endif

                <dl class="mt-8 divide-y divide-stone-100 border-y border-stone-200 text-sm">
                    @foreach ([
                        'Construction' => $fabric->construction,
                        'Composition' => $fabric->composition,
                        'Width' => $fabric->width,
                        'Weight' => $fabric->weight,
                        'Finish' => $fabric->finish,
                        'Available colours' => $fabric->colors,
                        'MOQ' => $fabric->moq,
                        'Lead time' => $fabric->lead_time,
                    ] as $label => $value)
                        @if ($value)
                            <div class="grid grid-cols-2 gap-4 py-3">
                                <dt class="font-medium text-stone-500">{{ $label }}</dt>
                                <dd class="text-stone-900">{{ $value }}</dd>
                            </div>
                        @endif
                    @endforeach
                </dl>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    @if ($inBasket)
                        <span class="inline-flex items-center gap-2 rounded-md bg-green-50 px-4 py-3 text-sm font-semibold text-green-700 ring-1 ring-inset ring-green-600/20">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            Added to your inquiry
                        </span>
                        <a href="{{ route('inquiry.index') }}" class="text-sm font-semibold text-brand-700 transition hover:text-brand-800">View inquiry basket &rarr;</a>
                    @else
                        <form method="POST" action="{{ route('inquiry.add', $fabric) }}">
                            @csrf
                            <x-primary-button>
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                Add to inquiry
                            </x-primary-button>
                        </form>
                        <a href="{{ route('contact') }}" class="text-sm font-semibold text-stone-600 transition hover:text-stone-900">Ask a question</a>
                    @endif
                </div>

                <p class="mt-6 text-xs leading-relaxed text-stone-500">
                    Pricing is quotation-based. Add fabrics to your inquiry basket and submit one request — our team responds with a consolidated offer, usually within one working day.
                </p>
            </div>
        </div>

        @if ($relatedFabrics->isNotEmpty())
            <section class="mt-20">
                <x-section-heading eyebrow="Related" :title="'More in '.$fabric->category->name" />
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($relatedFabrics as $relatedFabric)
                        <x-fabric-card :fabric="$relatedFabric" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
