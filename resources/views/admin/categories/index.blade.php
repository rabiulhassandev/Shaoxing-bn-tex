@extends('layouts.admin')

@section('title', 'Fabric Categories')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-stone-600">Group fabrics by composition or type. Categories power the catalogue filter.</p>
        <a href="{{ route('admin.categories.create') }}">
            <x-primary-button>Add category</x-primary-button>
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-stone-200 bg-white">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Fabrics</th>
                    <th class="px-4 py-3">Sort</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse ($categories as $category)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3 font-medium text-stone-900">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $category->slug }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $category->fabrics_count }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $category->sort_order }}</td>
                        <td class="px-4 py-3">
                            @if ($category->is_active)
                                <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-medium text-stone-600 ring-1 ring-inset ring-stone-500/20">Hidden</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">Edit</a>
                                <x-admin.delete-button :action="route('admin.categories.destroy', $category)"
                                    confirm="Delete this category? All fabrics inside it will be deleted too.">Delete</x-admin.delete-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-stone-500">No categories yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
@endsection
