@extends('layouts.admin')

@section('title', 'Statistics')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-stone-600">Counter figures shown on the homepage and About page (e.g. "12+ Years of Experience").</p>
        <a href="{{ route('admin.stats.create') }}">
            <x-primary-button>Add statistic</x-primary-button>
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-stone-200 bg-white">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                <tr>
                    <th class="px-4 py-3">Label</th>
                    <th class="px-4 py-3">Value</th>
                    <th class="px-4 py-3">Suffix</th>
                    <th class="px-4 py-3">Sort</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse ($stats as $stat)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3 font-medium text-stone-900">{{ $stat->label }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $stat->value }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $stat->suffix ?? '—' }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $stat->sort_order }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.stats.edit', $stat) }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">Edit</a>
                                <x-admin.delete-button :action="route('admin.stats.destroy', $stat)" confirm="Delete this statistic?">Delete</x-admin.delete-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-stone-500">No statistics yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
