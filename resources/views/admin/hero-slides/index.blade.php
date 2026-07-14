@extends('layouts.admin')

@section('title', 'Hero Slides')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-stone-600">Slides shown in the homepage hero banner, in sort order.</p>
        <a href="{{ route('admin.hero-slides.create') }}">
            <x-primary-button>Add slide</x-primary-button>
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-stone-200 bg-white">
        <table class="min-w-full divide-y divide-stone-200 text-sm">
            <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wider text-stone-500">
                <tr>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Button</th>
                    <th class="px-4 py-3">Sort</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse ($slides as $slide)
                    <tr class="hover:bg-stone-50">
                        <td class="px-4 py-3">
                            <img src="{{ $slide->image_url }}" alt="" class="h-12 w-24 rounded object-cover">
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-stone-900">{{ $slide->title }}</p>
                            <p class="mt-0.5 max-w-md truncate text-xs text-stone-500">{{ $slide->subtitle }}</p>
                        </td>
                        <td class="px-4 py-3 text-stone-500">{{ $slide->button_text ?? '—' }}</td>
                        <td class="px-4 py-3 text-stone-500">{{ $slide->sort_order }}</td>
                        <td class="px-4 py-3">
                            @if ($slide->is_active)
                                <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                            @else
                                <span class="inline-flex rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-medium text-stone-600 ring-1 ring-inset ring-stone-500/20">Hidden</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">Edit</a>
                                <x-admin.delete-button :action="route('admin.hero-slides.destroy', $slide)" confirm="Delete this slide?">Delete</x-admin.delete-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-stone-500">No slides yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
