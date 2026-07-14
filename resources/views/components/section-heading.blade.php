@props(['eyebrow' => null, 'title', 'subtitle' => null, 'center' => false])

<div {{ $attributes->merge(['class' => $center ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl']) }}>
    @if ($eyebrow)
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-600">{{ $eyebrow }}</p>
    @endif
    <h2 class="mt-2 text-2xl font-bold tracking-tight text-stone-900 sm:text-3xl">{{ $title }}</h2>
    @if ($subtitle)
        <p class="mt-3 text-base leading-relaxed text-stone-600">{{ $subtitle }}</p>
    @endif
</div>
