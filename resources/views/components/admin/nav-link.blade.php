@props(['href', 'active' => false, 'badge' => null])

<a href="{{ $href }}"
    {{ $attributes->merge(['class' => 'flex items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition '.($active ? 'bg-brand-800 text-white' : 'text-stone-300 hover:bg-brand-800/60 hover:text-white')]) }}>
    <span>{{ $slot }}</span>
    @if ($badge)
        <span class="rounded-full bg-red-500 px-2 py-0.5 text-xs font-semibold text-white">{{ $badge }}</span>
    @endif
</a>
