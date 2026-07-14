@extends('layouts.admin')

@section('title', 'Fabrics')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.fabrics.index') }}" class="flex flex-wrap items-center gap-2">
            <x-text-input name="search" type="search" class="w-56" placeholder="Search fabrics…" :value="request('search')" />
            <x-select-input name="category" class="w-48">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </x-select-input>
            <x-secondary-button type="submit">Filter</x-secondary-button>
        </form>
        <a href="{{ route('admin.fabrics.create') }}">
            <x-primary-button>Add fabric</x-primary-button>
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-stone-200 bg-white">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                <tr>
                    <th class="px-4 py-3">Fabric</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Construction</th>
                    <th class="px-4 py-3">Width</th>
                    <th class="px-4 py-3">Weight</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse ($fabrics as $fabric)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($fabric->image_url)
                                    <img src="{{ $fabric->image_url }}" alt="" class="size-10 rounded object-cover">
                                @else
                                    <div class="size-10 rounded bg-stone-100"></div>
                                @endif
                                <div>
                                    <p class="font-medium text-stone-900">{{ $fabric->name }}</p>
                                    @if ($fabric->is_featured)
                                        <p class="text-xs text-amber-600">Featured</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-stone-500">{{ $fabric->category->name }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $fabric->construction }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $fabric->width }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $fabric->weight }}</td>
                        <td class="px-4 py-3">
                            @if ($fabric->is_active)
                                <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-medium text-stone-600 ring-1 ring-inset ring-stone-500/20">Hidden</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('fabrics.show', $fabric) }}" target="_blank" class="text-sm font-medium text-stone-500 hover:text-stone-700">View</a>
                                <a href="{{ route('admin.fabrics.edit', $fabric) }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">Edit</a>
                                <x-admin.delete-button :action="route('admin.fabrics.destroy', $fabric)" confirm="Delete this fabric?">Delete</x-admin.delete-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-stone-500">No fabrics found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $fabrics->links() }}</div>
@endsection
