@props(['action', 'confirm' => 'Are you sure? This cannot be undone.'])

<form method="POST" action="{{ $action }}" x-data @submit.prevent="if (window.confirm(@js($confirm))) $el.submit()" {{ $attributes }}>
    @csrf
    @method('DELETE')
    <button type="submit" class="text-sm font-medium text-red-600 transition hover:text-red-800">{{ $slot }}</button>
</form>
