<button {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 rounded-md bg-brand-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 disabled:cursor-not-allowed disabled:opacity-50']) }}>
    {{ $slot }}
</button>
