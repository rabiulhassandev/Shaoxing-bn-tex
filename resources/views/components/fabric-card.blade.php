@props(['fabric', 'inBasket' => false])

<article {{ $attributes->merge(['class' => 'group flex flex-col overflow-hidden rounded-lg border border-stone-200 bg-white transition hover:border-brand-300 hover:shadow-sm']) }}>
    <a href="{{ route('fabrics.show', $fabric) }}" class="block aspect-[4/3] overflow-hidden bg-stone-100" tabindex="-1" aria-hidden="true">
        @if ($fabric->image_url)
            <img src="{{ $fabric->image_url }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]">
        @endif
    </a>

    <div class="flex flex-1 flex-col p-4">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-brand-600">{{ $fabric->category->name }}</p>
        <h3 class="mt-1 font-semibold leading-snug text-stone-900">
            <a href="{{ route('fabrics.show', $fabric) }}" class="transition hover:text-brand-800">{{ $fabric->name }}</a>
        </h3>

        <dl class="mt-3 space-y-1 text-sm text-stone-500">
            @if ($fabric->construction)
                <div class="flex justify-between gap-3"><dt>Construction</dt><dd class="text-right text-stone-700">{{ $fabric->construction }}</dd></div>
            @endif
            @if ($fabric->width)
                <div class="flex justify-between gap-3"><dt>Width</dt><dd class="text-right text-stone-700">{{ $fabric->width }}</dd></div>
            @endif
            @if ($fabric->weight)
                <div class="flex justify-between gap-3"><dt>Weight</dt><dd class="text-right text-stone-700">{{ $fabric->weight }}</dd></div>
            @endif
        </dl>

        <div class="mt-auto flex items-center justify-between gap-2 pt-4">
            <a href="{{ route('fabrics.show', $fabric) }}" class="text-sm font-medium text-brand-700 transition hover:text-brand-800">Details &rarr;</a>
            @if ($inBasket)
                <a href="{{ route('inquiry.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-green-700">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                    In inquiry
                </a>
            @else
                <form method="POST" action="{{ route('inquiry.add', $fabric) }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1 rounded-md border border-stone-300 px-2.5 py-1.5 text-xs font-semibold text-stone-700 transition hover:border-brand-400 hover:text-brand-800">
                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Add to inquiry
                    </button>
                </form>
            @endif
        </div>
    </div>
</article>
