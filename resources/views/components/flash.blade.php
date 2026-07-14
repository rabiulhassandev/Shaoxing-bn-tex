@if (session('status'))
    <div x-data="{ show: true }" x-show="show" role="status"
        class="mb-6 flex items-start justify-between gap-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        <p>{{ session('status') }}</p>
        <button type="button" @click="show = false" class="text-green-700 transition hover:text-green-900" aria-label="Dismiss">
            &times;
        </button>
    </div>
@endif
