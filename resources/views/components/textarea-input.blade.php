@props(['rows' => 4])

<textarea rows="{{ $rows }}" {{ $attributes->merge(['class' => 'block w-full rounded-md border border-stone-300 bg-white px-3 py-2 text-sm text-stone-900 shadow-xs placeholder:text-stone-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20']) }}>{{ $slot }}</textarea>
