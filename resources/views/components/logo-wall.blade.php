@props(['partners'])

<div {{ $attributes->merge(['class' => 'grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6']) }}>
    @foreach ($partners as $partner)
        <div class="flex h-20 items-center justify-center rounded-md border border-stone-200 bg-white px-4 transition hover:border-brand-200">
            @if ($partner->logo_url)
                <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" loading="lazy" class="max-h-12 w-full object-contain opacity-80 grayscale transition hover:opacity-100 hover:grayscale-0">
            @else
                <span class="text-center text-sm font-semibold text-stone-500">{{ $partner->name }}</span>
            @endif
        </div>
    @endforeach
</div>
