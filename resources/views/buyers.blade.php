@extends('layouts.public')

@section('title', 'Our Buyers')
@section('meta_description', 'International brands, wholesalers and garment makers who source fabrics through SHAOXING BN TEX, supported by our network of partner mills.')

@section('content')
    <div class="border-b border-stone-200 bg-stone-50">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Trusted worldwide" title="Our Buyers"
                subtitle="Garment makers, wholesalers and brands in more than 30 countries source their fabrics through BN TEX." />
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($buyers->isNotEmpty())
            <x-logo-wall :partners="$buyers" />
        @else
            <p class="py-10 text-center text-stone-500">Buyer references coming soon.</p>
        @endif

        @if ($vendors->isNotEmpty())
            <section class="mt-20">
                <x-section-heading eyebrow="Supply network" title="Partner mills & vendors"
                    subtitle="Long-standing relationships with weaving, dyeing and finishing mills give our buyers priority production slots and dependable quality." />
                <x-logo-wall :partners="$vendors" class="mt-10" />
            </section>
        @endif

        <div class="mt-20 rounded-lg bg-brand-900 px-6 py-12 text-center">
            <h2 class="text-2xl font-bold tracking-tight text-white">Want to join them?</h2>
            <p class="mx-auto mt-3 max-w-xl text-base text-stone-300">Send us your fabric requirements and see how straightforward sourcing from China can be.</p>
            <a href="{{ route('fabrics.index') }}" class="mt-6 inline-block rounded-md bg-white px-5 py-3 text-sm font-semibold text-brand-900 transition hover:bg-stone-100">Browse the catalogue</a>
        </div>
    </div>
@endsection
