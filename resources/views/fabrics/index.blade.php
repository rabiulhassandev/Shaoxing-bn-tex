@extends('layouts.public')

@section('title', $currentCategory ? $currentCategory->name.' Fabrics' : 'Fabric Catalogue')
@section('meta_description', $currentCategory?->description ?? 'Browse our fabric catalogue: cotton, T/C, CVC, linen, viscose, polyester, denim, corduroy and stretch qualities. Filter by composition and request pricing.')

@section('content')
    <div class="border-b border-stone-200 bg-stone-50">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Catalogue" title="Fabric Catalogue"
                subtitle="Filter by composition, search by name, and add fabrics to your inquiry basket to request one consolidated quotation." />

            <form method="GET" action="{{ route('fabrics.index') }}" class="mt-8 flex max-w-md gap-2">
                @if ($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory->slug }}">
                @endif
                <x-text-input name="search" type="search" placeholder="Search by name, composition or construction…" :value="request('search')" />
                <x-primary-button type="submit">Search</x-primary-button>
            </form>

            <div class="mt-6 flex flex-wrap gap-2">
                <a href="{{ route('fabrics.index', array_filter(['search' => request('search')])) }}"
                    class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ $currentCategory === null ? 'bg-brand-800 text-white' : 'border border-stone-300 bg-white text-stone-600 hover:border-brand-400 hover:text-brand-800' }}">
                    All ({{ $categories->sum('fabrics_count') }})
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('fabrics.index', array_filter(['category' => $category->slug, 'search' => request('search')])) }}"
                        class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ $currentCategory?->id === $category->id ? 'bg-brand-800 text-white' : 'border border-stone-300 bg-white text-stone-600 hover:border-brand-400 hover:text-brand-800' }}">
                        {{ $category->name }} ({{ $category->fabrics_count }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($fabrics->isNotEmpty())
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($fabrics as $fabric)
                    <x-fabric-card :fabric="$fabric" :in-basket="in_array($fabric->id, $basketIds, true)" />
                @endforeach
            </div>
            <div class="mt-10">{{ $fabrics->links() }}</div>
        @else
            <div class="rounded-lg border border-dashed border-stone-300 px-6 py-20 text-center">
                <p class="text-lg font-semibold text-stone-900">No fabrics found</p>
                <p class="mt-2 text-sm text-stone-500">Try a different search term or category — or contact us with your exact specification and we will source it for you.</p>
                <a href="{{ route('contact') }}" class="mt-6 inline-block">
                    <x-primary-button>Send us your specification</x-primary-button>
                </a>
            </div>
        @endif
    </div>
@endsection
